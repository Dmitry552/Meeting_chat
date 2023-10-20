import {ref, watch, onUpdated, onBeforeUnmount} from "vue";
import ACTIONS from "../socket/actions";
import freeice from "freeice";
import useSocket from "./useSocket";
import {Clients, Client} from "../types";

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

  const videoInputDevices = ref<MediaDeviceInfo[]>([]);
  const audioInputDevices = ref<MediaDeviceInfo[]>([]);
  const audioOutputDevices = ref<MediaDeviceInfo[]>([]);

  const currentVideoInputDevices = ref<MediaDeviceInfo>();
  const currentAudioInputDevices = ref<MediaDeviceInfo>();
  const currentAudioOutputDevices = ref<MediaDeviceInfo>();

  const addNewClient = (newClient: string): Client | undefined => {
    const client: Client = {
      name: newClient,
      control: {
        showAudio: true,
        showVideo: false
      }
    }

    if (!clients.value.find((value: Client): boolean => value?.name === LOCAL_VIDEO)) {
      clients.value.push(client);
      return client;
    }
  }

  const startCapture = async ():  Promise<void> => {
    await getDevises();

    navigator.mediaDevices.ondevicechange = async (): Promise<void> => {
      await getDevises();
    }

    await setLocalMediaStream();
    const client = addNewClient(LOCAL_VIDEO);
    client!.control.showVideo = true;
  }

  const setLocalMediaStream = async (): Promise<void> => {
    localMediaStream.value = await navigator.mediaDevices.getUserMedia({
      audio: {
        deviceId: currentAudioInputDevices.value!.deviceId
      },
      video: {
        deviceId: currentVideoInputDevices.value!.deviceId
      }
    });
    localMediaStream.value!.getAudioTracks()[0].enabled = showAudio.value;
  }

  const getDevises = async (): Promise<void> => {
    const devices: MediaDeviceInfo[] = await navigator.mediaDevices.enumerateDevices();

    videoInputDevices.value = devices.filter((device: MediaDeviceInfo): boolean => device.kind === 'videoinput');
    audioOutputDevices.value = devices.filter((device: MediaDeviceInfo): boolean => device.kind === 'audiooutput');
    audioInputDevices.value = devices.filter((device: MediaDeviceInfo): boolean => device.kind === 'audioinput');
    if (
      !currentVideoInputDevices.value || !videoInputDevices.value.find(
        (devise: MediaDeviceInfo): boolean => devise.deviceId === currentVideoInputDevices.value?.deviceId
      )
    ) {
      currentVideoInputDevices.value = videoInputDevices.value[0];
    }

    if (
      !currentAudioInputDevices.value || !audioInputDevices.value.find(
        (devise: MediaDeviceInfo): boolean => devise.deviceId === currentAudioInputDevices.value?.deviceId
      )
    ) {
      currentAudioInputDevices.value = audioInputDevices.value.find(
        (device: MediaDeviceInfo): boolean => device.deviceId === 'default'
      );
    }

    if (
      !currentAudioOutputDevices.value || !audioOutputDevices.value.find(
        (device: MediaDeviceInfo): boolean => device.deviceId === currentAudioOutputDevices.value?.deviceId
      )
    ) {
      currentAudioOutputDevices.value = audioOutputDevices.value.find(
        (device: MediaDeviceInfo): boolean => device.deviceId === 'default'
      );
    }
  }

  const setDevices = async (option: {id: string, name: string}): Promise<void> => {
    if (option.name === 'audioinput') {
      currentAudioInputDevices.value = audioInputDevices.value.find(
        (device: MediaDeviceInfo): boolean => device.deviceId === option.id
      );

      await setLocalMediaStream();
      peerMediaElements.value[LOCAL_VIDEO].srcObject = localMediaStream.value;
    } else if (option.name === 'videoinput') {
      currentVideoInputDevices.value = videoInputDevices.value.find(
        (device: MediaDeviceInfo): boolean => device.deviceId === option.id
      );

      await setLocalMediaStream();
      peerMediaElements.value[LOCAL_VIDEO].srcObject = localMediaStream.value;
    } else if (option.name === 'videooutput') {
      currentAudioOutputDevices.value = audioOutputDevices.value.find(
        (device: MediaDeviceInfo): boolean => device.deviceId === option.id
      );

      //await peerMediaElements.value[LOCAL_VIDEO].setSinkId(option.id);
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

    // let tracksNumber = 0; //two tracks, video + audio
    // peerConnections.value[peerID].ontrack = ({streams: [remoteStream]}) => {
    //   tracksNumber++;
    //   if (tracksNumber === 2) {
    //     addNewClient(peerID);
    //     clientsMediaStream.value[peerID] = remoteStream;
    //   }
    // }

    peerConnections.value[peerID].ontrack = (event: RTCTrackEvent): void => {
      console.log('event', event)
      const client = addNewClient(peerID);
      clientsMediaStream.value[(peerID as string)] = event.streams[0];
      client!.control.showVideo = true;
    }

    localMediaStream.value?.getTracks().forEach((track: MediaStreamTrack): void => {
      peerConnections.value[peerID].addTrack(track, localMediaStream.value as MediaStream)
    })

    if (createOffer) {
      const offer: RTCSessionDescriptionInit = await peerConnections.value[peerID].createOffer();
      await peerConnections.value[peerID].setLocalDescription(offer);
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
      localMediaStream.value!.getVideoTracks()[0].stop();
    } else {
      await setLocalMediaStream();
      peerMediaElements.value['LOCAL_VIDEO'].srcObject = localMediaStream.value;
      showVideo.value = true;
      (client as Client)!.control.showVideo = true;
    }
  }

  const handleMuteAudio = (): void => {
    const client: Client | undefined = clients.value.find((value: Client): boolean => value?.name === LOCAL_VIDEO);

    if (showAudio.value) {
      showAudio.value = false;

      if (client) {
        (client as Client)!.control.showAudio = false;
      }

      localMediaStream.value!.getAudioTracks()[0].enabled = false;
    } else {
      showAudio.value = true;

      if (client) {
        (client as Client)!.control.showAudio = true;
      }

      localMediaStream.value!.getAudioTracks()[0].enabled = true;
    }
  }

  const handleScreenBroadcast = async (): Promise<void> => {
    const client: Client | undefined = clients.value.find((value: Client): boolean => value?.name === LOCAL_VIDEO);

    if (!showScreenBroadcast.value) {
      console.log('fvdfvdfvdfv');
      showScreenBroadcast.value = true;
      (client as Client)!.control.showVideo = false;
      try {
        localMediaStream.value = await navigator.mediaDevices.getDisplayMedia({video: true, audio: true});
        peerMediaElements.value['LOCAL_VIDEO'].srcObject = localMediaStream.value;
        (client as Client)!.control.showVideo = true;
      } catch (e) {
        console.log(e);
      }
    } else {
      (client as Client)!.control.showVideo = false;
      localMediaStream.value!.getTracks().forEach(track => track.stop());
      await setLocalMediaStream();
      peerMediaElements.value['LOCAL_VIDEO'].srcObject = localMediaStream.value;
      (client as Client)!.control.showVideo = true;
      showScreenBroadcast.value = false;
    }
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
        peerMediaElements.value[LOCAL_VIDEO].volume = 1;
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
  // listen(ACTIONS.MUTED_VIDEO_STREAM, handleMutedVideo)

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
    handleMuteVideo,
    handleMuteAudio,
    handleScreenBroadcast,
    handleHungUp,
    setDevices
  }
}
