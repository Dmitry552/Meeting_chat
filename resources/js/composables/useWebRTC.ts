import {ref, watch, onUpdated, onBeforeUnmount} from "vue";
import ACTIONS from "../socket/actions";
import freeice from "freeice";
import useSocket from "./useSocket";
import {Clients, Client, TDevice} from "../types";
import {getFilteredDevices} from "../utils/helpers";

export const LOCAL_VIDEO: string = 'LOCAL_VIDEO';

export type TPeerMediaElement = {
  [key: string]: HTMLVideoElement
}

type TPeerConnections = {
  [key: string]: RTCPeerConnection
}

type TClientsMediaStream = {
  [key: string]: MediaStream
}

export default function useWebRTC(id: string) {
console.log('useWebRTC');

  const {
    action,
    listen
  } = useSocket();

  const roomID = ref<string>(id);
  const localMediaStream = ref<MediaStream | null>(null);
  const peerMediaElements= ref<TPeerMediaElement>({});
  const peerConnections = ref<TPeerConnections>({});
  const clients = ref<Clients>([]);
  const clientsMediaStream = ref<TClientsMediaStream>({});

  const videos = ref<HTMLVideoElement[]>([]);
  const showVideo = ref<boolean>(true);
  const showAudio = ref<boolean>(true);
  const showScreenBroadcast = ref<boolean>(false);

  const videoInputDevices = ref<TDevice[]>([]);
  const audioInputDevices = ref<TDevice[]>([]);
  const audioOutputDevices = ref<TDevice[]>([]);

  const currentVideoInputDevices = ref<TDevice>();
  const currentAudioInputDevices = ref<TDevice>();
  const currentAudioOutputDevices = ref<TDevice>();

  const addNewClient = (newClient: string): Client | undefined => {
    const client: Client = {
      name: newClient,
      control: {
        showAudio: true,
        showVideo: true
      }
    }

    if (!clients.value.find((value: Client): boolean => value?.name === newClient)) {
      console.log('fff');
      clients.value.push(client);
      return client;
    }
  }

  const startCapture = async (): Promise<void> => {
    await getDevises();

    navigator.mediaDevices.ondevicechange = async (): Promise<void> => {
      await getDevises();
    }

    await setLocalMediaStream();

    const client = addNewClient(LOCAL_VIDEO);
  }

  const setLocalMediaStream = async (value?: 'audio'): Promise<void> => {
    if (value) {
      localMediaStream.value = await navigator.mediaDevices.getUserMedia({
        audio: {
          deviceId: currentAudioInputDevices.value!.deviceId
        },
      });
    } else {
      localMediaStream.value = await navigator.mediaDevices.getUserMedia({
        audio: {
          deviceId: currentAudioInputDevices.value!.deviceId
        },
        video: {
          deviceId: currentVideoInputDevices.value!.deviceId
        }
      });
    }

    localMediaStream.value!.getAudioTracks()[0].enabled = showAudio.value;
  }

  const changingMediaStreamForPeers = (value?: 'audio' | 'video') => {
    for (let key in peerConnections.value) {
      const tracks: MediaStreamTrack[] = localMediaStream.value!.getTracks();
      const senders: RTCRtpSender[] = peerConnections.value[key].getSenders();

      senders.forEach((sender: RTCRtpSender): void => {
        peerConnections.value[key].removeTrack(sender!);
      })

      tracks.forEach((track: MediaStreamTrack): void => {
        if (track.kind === 'video') {
          track.enabled = showVideo.value
        } else if (track.kind === 'audio') {
          track.enabled = showVideo.value
        }

        peerConnections.value[key].addTrack(
          track,
          (localMediaStream.value as MediaStream)
        );
      })
    }
  }

  const getDevises = async (): Promise<void> => {
    try {
      const devices: MediaDeviceInfo[] = await navigator.mediaDevices.enumerateDevices();

      videoInputDevices.value = getFilteredDevices(devices, 'videoinput');
      audioOutputDevices.value = getFilteredDevices(devices, 'audiooutput');
      audioInputDevices.value = getFilteredDevices(devices, 'audioinput');

      if (
        !currentVideoInputDevices.value || !videoInputDevices.value.find(
          (devise: TDevice): boolean => devise.deviceId === currentVideoInputDevices.value?.deviceId
        )
      ) {
        currentVideoInputDevices.value = videoInputDevices.value[0];
      }

      if (
        !currentAudioInputDevices.value || !audioInputDevices.value.find(
          (devise: TDevice): boolean => devise.deviceId === currentAudioInputDevices.value?.deviceId
        )
      ) {
        currentAudioInputDevices.value = audioInputDevices.value[0];
      }

      if (
        !currentAudioOutputDevices.value || !audioOutputDevices.value.find(
          (device: TDevice): boolean => device.deviceId === currentAudioOutputDevices.value?.deviceId
        )
      ) {
        currentAudioOutputDevices.value = audioOutputDevices.value[0];
      }
    } catch (e) {
      console.log(e)
    }
  }

  const setDevices = async (option: {id: string, name: string}): Promise<void> => {
    if (option.name === 'audioinput') {
      currentAudioInputDevices.value = audioInputDevices.value.find(
        (device: TDevice): boolean => device.deviceId === option.id
      );

      await setLocalMediaStream();
      peerMediaElements.value[LOCAL_VIDEO].srcObject = localMediaStream.value;
    } else if (option.name === 'videoinput') {
      currentVideoInputDevices.value = videoInputDevices.value.find(
        (device: TDevice): boolean => device.deviceId === option.id
      );

      await setLocalMediaStream();
      peerMediaElements.value[LOCAL_VIDEO].srcObject = localMediaStream.value;
    } else if (option.name === 'videooutput') {
      currentAudioOutputDevices.value = audioOutputDevices.value.find(
        (device: TDevice): boolean => device.deviceId === option.id
      );
    }
  }

  const setRemoteMedia = async (
    {
      peerID,
      sessionDescription: remoteDescription
    }: {
      peerID: string,
      sessionDescription: RTCSessionDescriptionInit
    }
  ): Promise<void> => {
    console.log('setRemoteMedia', remoteDescription)
    await peerConnections.value[peerID].setRemoteDescription(
      new RTCSessionDescription(remoteDescription)
    );

    if (remoteDescription.type === 'offer') {
      const answer: RTCSessionDescriptionInit = await peerConnections.value[peerID].createAnswer();
      await peerConnections.value[peerID].setLocalDescription(answer);
      action(ACTIONS.RELAY_SDP, {
        room: peerID,
        sessionDescription: answer
      });
    }
  }

  const handleNewPeer = async (
    {
      peerID,
      createOffer
    }: {
      peerID: string,
      createOffer: boolean
    }
  ): Promise<void> => {
    console.log(peerID, createOffer);
    if (peerID in peerConnections.value) {
      console.warn(`Already connected to peer ${peerID}`)
    }

    peerConnections.value[peerID] = new RTCPeerConnection({
      iceServers: freeice()
    })

    peerConnections.value[peerID].onicecandidate = (event: RTCPeerConnectionIceEvent): void => {
      if (event.candidate) {
        action(ACTIONS.RELAY_ICE, {
          room: peerID,
          iceCandidate: event.candidate
        })
      }
    }

    peerConnections.value[peerID].ontrack = (event: RTCTrackEvent): void => {

      addNewClient(peerID);

      clientsMediaStream.value[(peerID as string)] = event.streams[0];
      console.log('event', peerMediaElements.value[(peerID as string)])
      // if (peerMediaElements.value[(peerID as string)]) {
      //   peerMediaElements.value[(peerID as string)].srcObject = event.streams[0];
      // }
    }

    localMediaStream.value?.getTracks().forEach((track: MediaStreamTrack): void => {
      peerConnections.value[peerID].addTrack(track, localMediaStream.value as MediaStream)
    })

    // let countNegotiationneeded: boolean = false;
    // peerConnections.value[peerID].onnegotiationneeded = async (event) => {
    //   console.log('negotiationneeded', createOffer, countNegotiationneeded);
    //
    //   if (countNegotiationneeded) {
    //     const offer: RTCSessionDescriptionInit = await peerConnections.value[peerID].createOffer();
    //     await peerConnections.value[peerID].setLocalDescription(offer);
    //     action(ACTIONS.RELAY_SDP, {
    //       room: peerID,
    //       sessionDescription: offer
    //     });
    //   }
    //   countNegotiationneeded = true;
    // }

    if (createOffer) {
      // countNegotiationneeded = false;

      const offer: RTCSessionDescriptionInit = await peerConnections.value[peerID].createOffer();
      await peerConnections.value[peerID].setLocalDescription(offer);
      console.log('createOffer', offer)
      action(ACTIONS.RELAY_SDP, {
        room: peerID,
        sessionDescription: offer
      });
    }
  }

  const handleMuteVideo = async (): Promise<void> => {
    const client: Client | undefined = clients.value.find((value: Client): boolean => value?.name === LOCAL_VIDEO);

    if (showVideo.value) {
      showVideo.value = false;
      (client as Client)!.control.showVideo = false;
      await setLocalMediaStream('audio');
      action(ACTIONS.MUTE, {room: roomID.value, value: false, key: 'video'})

    } else {
      await setLocalMediaStream();
      peerMediaElements.value['LOCAL_VIDEO'].srcObject = localMediaStream.value;
      showVideo.value = true;
      (client as Client)!.control.showVideo = true;
      action(ACTIONS.MUTE, {room: roomID.value, value: true, key: 'video'})
    }

    //changingMediaStreamForPeers();
  }

  const handleMutedVideoClient = async (
    {
      peerID,
      track
    }: {
      peerID: string,
      track: MediaStreamTrack
    }
  ): Promise<void> => {
    const client: Client | undefined = clients.value.find((value: Client): boolean => value?.name === peerID);

    // if (peerConnections.value[peerID]) {
    //   peerConnections.value[peerID].close();
    // }

    console.log(peerConnections.value[peerID])

    console.log('handleMutedVideoClient', peerID, track);
  }

  const handleMuteAudio = (): void => {
    const client: Client | undefined = clients.value.find((value: Client): boolean => value?.name === LOCAL_VIDEO);

    if (showAudio.value) {
      showAudio.value = false;

      (client as Client)!.control.showAudio = false;

      localMediaStream.value!.getAudioTracks()[0].enabled = false;

      action(ACTIONS.MUTE, {room: roomID.value, value: false, key: 'audio'})
    } else {
      showAudio.value = true;

      (client as Client)!.control.showAudio = true;

      localMediaStream.value!.getAudioTracks()[0].enabled = true;

      action(ACTIONS.MUTE, {room: roomID.value, value: true, key: 'audio'})
    }
  }

  const handleMutedClient = (
    {
      peerID,
      value,
      key
    }: {
      peerID: string,
      value: boolean,
      key: 'audio' | 'video'
    }): void => {
    const client: Client | undefined = clients.value.find((value: Client): boolean => value?.name === peerID);

    if (key === 'audio') {
      (client as Client)!.control.showAudio = value;
      clientsMediaStream.value[peerID].getAudioTracks()[0].enabled = value;
    } else {
      (client as Client)!.control.showVideo = value;
      clientsMediaStream.value[peerID].getVideoTracks()[0].enabled = value;
    }
    console.log(client);
  }

  const handleScreenBroadcast = async (): Promise<void> => {
    const client: Client | undefined = clients.value.find((value: Client): boolean => value?.name === LOCAL_VIDEO);

    if (!showScreenBroadcast.value) {
      showScreenBroadcast.value = true;
      (client as Client)!.control.showVideo = false;

      localMediaStream.value = await navigator.mediaDevices.getDisplayMedia({video: true, audio: true});
      peerMediaElements.value['LOCAL_VIDEO'].srcObject = localMediaStream.value;
      (client as Client)!.control.showVideo = true;
    } else {
      (client as Client)!.control.showVideo = false;
      localMediaStream.value!.getTracks().forEach((track: MediaStreamTrack): void => track.stop());
      await setLocalMediaStream();
      peerMediaElements.value['LOCAL_VIDEO'].srcObject = localMediaStream.value;
      (client as Client)!.control.showVideo = true;
      showScreenBroadcast.value = false;
    }

    changingMediaStreamForPeers();
  }

  const handleHungUp = (): void => {
    localMediaStream.value!.getTracks().forEach((track: MediaStreamTrack) => track.stop())
    action(ACTIONS.LEAVE);
  }

  const handleRemovePeer = ({peerID}: {peerID: string}): void => {
    if (peerConnections.value[peerID]) {
      peerConnections.value[peerID].close();
    }

    delete peerConnections.value[peerID];
    delete peerMediaElements.value[peerID];
    delete clientsMediaStream.value[peerID];

    clients.value = clients.value.filter((client: Client): boolean => client!.name !== peerID);
  }

  const handleNewCandidate = ({peerID, iceCandidate}: {peerID: string, iceCandidate: RTCIceCandidate}): void => {
    peerConnections.value[peerID].addIceCandidate(
      new RTCIceCandidate(iceCandidate)
    ).then();
  }

  onUpdated((): void => {
    videos.value.forEach((video: HTMLVideoElement, index: number): void => {
      peerMediaElements.value[`${clients.value[index]!.name}`] = video;
      if (clients.value[index]!.name === LOCAL_VIDEO && !peerMediaElements.value[LOCAL_VIDEO].srcObject) {
        peerMediaElements.value[LOCAL_VIDEO].volume = 0;
        peerMediaElements.value[LOCAL_VIDEO].srcObject = localMediaStream.value;
        return;
      }
      if(!peerMediaElements.value[clients.value[index]!.name].srcObject) {
        peerMediaElements.value[clients.value[index]!.name].srcObject = clientsMediaStream.value[clients.value[index]!.name];
      }
    })
  });

  onBeforeUnmount((): void => {
    console.log('onBeforeUnmount');
    try {
      localMediaStream.value!.getTracks().forEach((track: MediaStreamTrack) => track.stop())
      action(ACTIONS.LEAVE);
    } catch (e) {

    }
  });


  watch(roomID, (): void => {
    startCapture()
      .then(() => action(ACTIONS.JOIN, {room: roomID.value}))
      .catch((error) => console.error(`Error getting userMedia: ${error}`));
  });

  watch(videos, () => {
    console.log('kmkmkmkm');
  });

  listen(ACTIONS.ADD_PEER, handleNewPeer);
  listen(ACTIONS.SESSION_DESCRIPTION, setRemoteMedia);
  listen(ACTIONS.ICE_CANDIDATE, handleNewCandidate);
  listen(ACTIONS.REMOVE_PEER, handleRemovePeer);
  listen(ACTIONS.MUTED, handleMutedClient)
  //listen(ACTIONS.MUTED_VIDEO_STREAM, handleMutedVideoClient)

  return {
    videos,
    clients,
    peerMediaElements,
    localMediaStream,
    clientsMediaStream,
    showVideo,
    showAudio,
    audioOutputDevices,
    audioInputDevices,
    videoInputDevices,
    currentVideoInputDevices,
    currentAudioInputDevices,
    currentAudioOutputDevices,
    startCapture,
    addNewClient,
    handleMuteVideo,
    handleMuteAudio,
    handleScreenBroadcast,
    handleHungUp,
    setDevices
  }
}
