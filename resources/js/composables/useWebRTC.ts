import {ref, onUpdated, onBeforeUnmount, computed, watch} from "vue";
import ACTIONS from "../socket/actions";
import freeice from "freeice";
import useSocket from "./useSocket";
import {TDevice, Interlocutor, Room} from "../types";
import {getFilteredDevices} from "../utils/helpers";
import {useStore} from "../store";
import {translationIce} from "../store/modules/VideoChat/actions";
import {TMuteData, TTranslationIceData, TTranslationSpdData} from "../store/modules/VideoChat/types";
import {getInterlocutor} from "../store/modules/Interlocutor/actions";
import {
  removeInterlocutor,
  updateInterlocutor
} from '../store/modules/Interlocutor/mutations'

// export const LOCAL_VIDEO: string = 'LOCAL_VIDEO';

// export type TPeerMediaElement = {
//   [key: string]: HTMLVideoElement
// }
//
// type TPeerConnections = {
//   [key: string]: RTCPeerConnection
// }
//
// type TClientsMediaStream = {
//   [key: string]: MediaStream
// }

export default function useWebRTC() {
console.log('useWebRTC');

  // const {
  //   listenChannel
  // } = useSocket();

  const store = useStore();

  // const roomID = ref<string>(id);
  // const localMediaStream = ref<MediaStream | null>(null);
  // const peerMediaElements= ref<TPeerMediaElement>({});
  // const peerConnections = ref<TPeerConnections>({});
  // const clients = ref<Clients>([]);
  // const clientsMediaStream = ref<TClientsMediaStream>({});

  const interlocutor = ref<Interlocutor>(); //+
  const localMediaStream = ref<MediaStream>();

  const videos = ref<HTMLVideoElement[]>([]); //+
  const showVideo = ref<boolean>(true); //+
  const showAudio = ref<boolean>(true); //+
  const showScreenBroadcast = ref<boolean>(false); //+

  const videoInputDevices = ref<TDevice[]>([]); //+
  const audioInputDevices = ref<TDevice[]>([]); //+
  const audioOutputDevices = ref<TDevice[]>([]); //+

  const currentVideoInputDevices = ref<TDevice>(); //+
  const currentAudioInputDevices = ref<TDevice>(); //+
  const currentAudioOutputDevices = ref<TDevice>(); //+

  const currentInterlocutor = computed<Interlocutor>(() => store.getters.getCurrentInterlocutor);
  const interlocutors = computed<Interlocutor[]>(() => store.getters.getInterlocutorsRoom);
  const room = computed<Room>(() => store.getters.getRoom);

  const translationIce = (data: TTranslationIceData) => store.dispatch('translationIce', data);
  const translationSdp = (data: TTranslationSpdData) => store.dispatch('translationSdp', data);
  const leave = () => store.dispatch('leave');
  const muteStream = (data: TMuteData) => store.dispatch('mute', data);
  const getNewInterlocutor = (data: string) => store.dispatch('getInterlocutor', data);

  // const addNewClient = (newClient: string): Client | undefined => {
    // setCurrentInterlocutorMediaControl({
    //   showAudio: true,
    //   showVideo: true
    // });

    // const client: Client = {
    //   name: newClient,
    //   control: {
    //     showAudio: true,
    //     showVideo: true
    //   }
    // }

    // if (!clients.value.find((value: Client): boolean => value?.name === newClient)) {
    //   console.log('fff');
    //   clients.value.push(client);
    //   return client;
    // }
  // }

  const getInterlocutor = async (interlocutorCode: string): Promise<void> => {
    let data;
    let _interlocutor =  interlocutors.value.find(
      (interlocutor: Interlocutor): boolean => interlocutor.code === interlocutorCode
    )

    if (!_interlocutor) {
      data = await getNewInterlocutor(interlocutorCode);
      _interlocutor = data;
    }

    interlocutor.value = _interlocutor;
  }

  const startCapture = async (): Promise<void> => {
    await getInterlocutor(currentInterlocutor.value.code);
    console.log('getInterlocutor', interlocutor.value);

    navigator.mediaDevices.ondevicechange = async (): Promise<void> => {
      await getDevises();
    }

    await setLocalMediaStream();
    console.log('setLocalMediaStream', interlocutor.value);
    await getDevises();

    interlocutor.value!.control = {
      showAudio: true,
      showVideo: true
    }

    updateInterlocutor(interlocutor.value as Interlocutor);
    console.log('updateInterlocutor', interlocutor.value);
    await handleNewPeer({
      interlocutorCode: currentInterlocutor.value.code,
      createOffer: false
    });
    // const client = addNewClient(LOCAL_VIDEO);
  }

  const setLocalMediaStream = async (value?: 'audio'): Promise<void> => {
    let localMediaStream: MediaStream;
    let constraintsNoVideo = currentAudioInputDevices.value
      ? {
        audio: {
          deviceId: currentAudioInputDevices.value?.deviceId
        },
      }
    : { audio: true }

    let constraints = (currentAudioInputDevices.value && currentVideoInputDevices.value)
    ? {
        audio: {
          deviceId: currentAudioInputDevices.value?.deviceId
        },
        video: {
          deviceId: currentVideoInputDevices.value?.deviceId
        }
      }
    : {audio: true, video: true}

    if (value) {
      localMediaStream = await navigator.mediaDevices.getUserMedia(constraintsNoVideo);
    } else {
      localMediaStream = await navigator.mediaDevices.getUserMedia(constraints);
    }

    localMediaStream.getAudioTracks()[0].enabled = showAudio.value;

    interlocutor.value!.mediaStream = localMediaStream;
  }

  // const changingMediaStreamForPeers = (value?: 'audio' | 'video') => {
  //   for (let key in peerConnections.value) {
  //     const tracks: MediaStreamTrack[] = localMediaStream.value!.getTracks();
  //     const senders: RTCRtpSender[] = peerConnections.value[key].getSenders();
  //
  //     senders.forEach((sender: RTCRtpSender): void => {
  //       peerConnections.value[key].removeTrack(sender!);
  //     })
  //
  //     tracks.forEach((track: MediaStreamTrack): void => {
  //       if (track.kind === 'video') {
  //         track.enabled = showVideo.value
  //       } else if (track.kind === 'audio') {
  //         track.enabled = showVideo.value
  //       }
  //
  //       peerConnections.value[key].addTrack(
  //         track,
  //         (localMediaStream.value as MediaStream)
  //       );
  //     })
  //   }
  // }

  const getDevises = async (): Promise<void> => {
    try {
      const devices: MediaDeviceInfo[] = await navigator.mediaDevices.enumerateDevices();
      // navigator.mediaDevices.enumerateDevices().then(data => {
      //   console.log('devices', data);
      // })

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
    } catch (err) {
      console.warn(err);
    }
  }

  const setDevices = async (option: {id: string, name: string}): Promise<void> => {
    await getInterlocutor(currentInterlocutor.value.code);

    if (option.name === 'audioinput') {
      currentAudioInputDevices.value = audioInputDevices.value.find(
        (device: TDevice): boolean => device.deviceId === option.id
      );

      await setLocalMediaStream();
      interlocutor.value!.peerMediaElement!.srcObject = interlocutor.value!.mediaStream as MediaStream;
    } else if (option.name === 'videoinput') {
      currentVideoInputDevices.value = videoInputDevices.value.find(
        (device: TDevice): boolean => device.deviceId === option.id
      );

      await setLocalMediaStream();
      interlocutor.value!.peerMediaElement!.srcObject = interlocutor.value!.mediaStream as MediaStream;
    } else if (option.name === 'videooutput') {
      currentAudioOutputDevices.value = audioOutputDevices.value.find(
        (device: TDevice): boolean => device.deviceId === option.id
      );
    }

    updateInterlocutor(interlocutor.value!);
  }

  const setRemoteMedia = async (
    {
      interlocutorCode,
      // peerID
      sessionDescription: remoteDescription
    }: {
      interlocutorCode: string,
      // peerID: string,
      sessionDescription: RTCSessionDescriptionInit
    }
  ): Promise<void> => {
    console.log('setRemoteMedia', remoteDescription)
    // await peerConnections.value[peerID].setRemoteDescription(
    //   new RTCSessionDescription(remoteDescription)
    // );
    await getInterlocutor(interlocutorCode);
    console.log('getInterlocutor', interlocutor.value!)
    await interlocutor.value!.peerConnection!.setRemoteDescription(
      new RTCSessionDescription(remoteDescription)
    );

    if (remoteDescription.type === 'offer') {
      console.log('offer');
      const answer: RTCSessionDescriptionInit = await interlocutor.value!.peerConnection!.createAnswer();
      await interlocutor.value!.peerConnection!.setLocalDescription(answer);
      // const answer: RTCSessionDescriptionInit = await peerConnections.value[peerID].createAnswer();
      // await peerConnections.value[peerID].setLocalDescription(answer);

      await translationSdp({
        interlocutorCode,
        sessionDescription: answer
      });
      // action(ACTIONS.RELAY_SDP, {
      //   room: peerID,
      //   sessionDescription: answer
      // });
    }

    updateInterlocutor(interlocutor.value!);
  }

  const handleNewPeer = async (
    {
      interlocutorCode,
      createOffer
    }: {
      interlocutorCode: string,
      createOffer: boolean
    }
  ): Promise<void> => {
    console.log('handleNewPeer');
    await getInterlocutor(interlocutorCode);

    if (interlocutor.value!.peerConnection) {
      console.warn(`Already connected to peer ${interlocutorCode}`)
    }

    // if (peerID in peerConnections.value) {
    //   console.warn(`Already connected to peer ${peerID}`)
    // }

    if (interlocutor.value!.code !== currentInterlocutor.value.code) {
      localMediaStream.value = interlocutors.value.find(
        (interlocutor: Interlocutor): boolean => interlocutor.code === currentInterlocutor.value.code
      )!.mediaStream;
    } else {
      localMediaStream.value = interlocutor.value!.mediaStream;
    }

    interlocutor.value!.peerConnection = new RTCPeerConnection({
      iceServers: freeice()
    })
    // peerConnections.value[peerID] = new RTCPeerConnection({
    //   iceServers: freeice()
    // })

    interlocutor.value!.peerConnection!.onicecandidate = async (event: RTCPeerConnectionIceEvent): Promise<void> => {
      if (event.candidate) {
        await translationIce({
          interlocutorCode,
          iceCandidate: event.candidate
        })
        // action(ACTIONS.RELAY_ICE, {
        //   room: interlocutorCode,
        //   iceCandidate: event.candidate
        // })
      }
    }

    // peerConnections.value[peerID].onicecandidate = (event: RTCPeerConnectionIceEvent): void => {
    //   if (event.candidate) {
    //     action(ACTIONS.RELAY_ICE, {
    //       room: peerID,
    //       iceCandidate: event.candidate
    //     })
    //   }
    // }

    interlocutor.value!.peerConnection!.ontrack = (event: RTCTrackEvent): void => {
      console.log('peerConnection.ontrack');
      interlocutor.value!.mediaStream = event.streams[0];
    }

    // peerConnections.value[peerID].ontrack = (event: RTCTrackEvent): void => {
    //
    //   addNewClient(peerID);
    //
    //   clientsMediaStream.value[(peerID as string)] = event.streams[0];
    //   console.log('event', peerMediaElements.value[(peerID as string)])
    //   // if (peerMediaElements.value[(peerID as string)]) {
    //   //   peerMediaElements.value[(peerID as string)].srcObject = event.streams[0];
    //   // }
    // }

    console.log('1', localMediaStream.value);
    localMediaStream.value!.getTracks().forEach((track: MediaStreamTrack): void => {
      interlocutor.value!.peerConnection!.addTrack(track, localMediaStream.value as MediaStream)
    })

    // localMediaStream.value?.getTracks().forEach((track: MediaStreamTrack): void => {
    //   peerConnections.value[peerID].addTrack(track, localMediaStream.value as MediaStream)
    // })

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

      const offer: RTCSessionDescriptionInit = await interlocutor.value!.peerConnection.createOffer();
      await interlocutor.value!.peerConnection.setLocalDescription(offer);

      await translationSdp({
        interlocutorCode,
        sessionDescription: offer
      });
      // action(ACTIONS.RELAY_SDP, {
      //   room: peerID,
      //   sessionDescription: offer
      // });
    }

    updateInterlocutor(interlocutor.value as Interlocutor);
  }

  const handleMuteVideo = async (): Promise<void> => {
    await getInterlocutor(currentInterlocutor.value.code);
    // const client: Client | undefined = clients.value.find((value: Client): boolean => value?.name === LOCAL_VIDEO);

    if (showVideo.value) {
      showVideo.value = false;
      interlocutor.value!.control!.showVideo = false;
      // (client as Client)!.control.showVideo = false;
      await setLocalMediaStream('audio');
      await muteStream({
          interlocutorCode: currentInterlocutor.value!.code,
          value: false,
          key: 'video'
        }
      );
      // action(ACTIONS.MUTE, {room: roomID.value, value: false, key: 'video'})

    } else {
      await setLocalMediaStream();
      interlocutor.value!.peerMediaElement!.srcObject = interlocutor.value!.mediaStream as MediaStream;
      // peerMediaElements.value['LOCAL_VIDEO'].srcObject = localMediaStream.value;
      showVideo.value = true;
      interlocutor.value!.control!.showVideo = true;
      // (client as Client)!.control.showVideo = true;
      await muteStream({
          interlocutorCode: currentInterlocutor.value!.code,
          value: false,
          key: 'video'
        }
      );
      // action(ACTIONS.MUTE, {room: roomID.value, value: true, key: 'video'})
    }

    //changingMediaStreamForPeers();
  }

  const handleMuteAudio = async (): Promise<void> => {
    await getInterlocutor(currentInterlocutor.value.code);
    // const client: Client | undefined = clients.value.find((value: Client): boolean => value?.name === LOCAL_VIDEO);

    if (showAudio.value) {
      showAudio.value = false;
      interlocutor.value!.control!.showVideo = false;
      // (client as Client)!.control.showAudio = false;
      interlocutor.value!.mediaStream!.getAudioTracks()[0].enabled = false;
      // localMediaStream.value!.getAudioTracks()[0].enabled = false;
      await muteStream({
          interlocutorCode: currentInterlocutor.value!.code,
          value: false,
          key: 'audio'
        }
      );
      // action(ACTIONS.MUTE, {room: roomID.value, value: false, key: 'audio'})
    } else {
      showAudio.value = true;
      interlocutor.value!.control!.showVideo = true;
      // (client as Client)!.control.showAudio = true;
      interlocutor.value!.mediaStream!.getAudioTracks()[0].enabled = true;
      // localMediaStream.value!.getAudioTracks()[0].enabled = true;
      await muteStream({
          interlocutorCode: currentInterlocutor.value!.code,
          value: true,
          key: 'audio'
        }
      );
      // action(ACTIONS.MUTE, {room: roomID.value, value: true, key: 'audio'})
    }

    updateInterlocutor(interlocutor.value!)
  }

  // const handleMutedVideoClient = async (
  //   {
  //     peerID,
  //     track
  //   }: {
  //     peerID: string,
  //     track: MediaStreamTrack
  //   }
  // ): Promise<void> => {
  //   const client: Client | undefined = clients.value.find((value: Client): boolean => value?.name === peerID);
  //
  //   // if (peerConnections.value[peerID]) {
  //   //   peerConnections.value[peerID].close();
  //   // }
  //
  //   console.log(peerConnections.value[peerID])
  //
  //   console.log('handleMutedVideoClient', peerID, track);
  // }

  const handleMutedClient = async (
    {
      interlocutorCode,
      value,
      key
    }: {
      interlocutorCode: string,
      value: boolean,
      key: 'audio' | 'video'
    }): Promise<void> => {
    await getInterlocutor(interlocutorCode);
    //const client: Client | undefined = clients.value.find((value: Client): boolean => value?.name === peerID);

    if (key === 'audio') {
      interlocutor.value!.control!.showAudio = value;
      // (client as Client)!.control.showAudio = value;
      interlocutor.value!.mediaStream!.getAudioTracks()[0].enabled = value;
      // clientsMediaStream.value[peerID].getAudioTracks()[0].enabled = value;
    } else {
      interlocutor.value!.control!.showAudio = value;
      // (client as Client)!.control.showVideo = value;
      interlocutor.value!.mediaStream!.getAudioTracks()[0].enabled = value;
      // clientsMediaStream.value[peerID].getVideoTracks()[0].enabled = value;
    }

    updateInterlocutor(interlocutor.value!);
  }

  const handleScreenBroadcast = async (): Promise<void> => {
    await getInterlocutor(currentInterlocutor.value!.code);
    // const client: Client | undefined = clients.value.find((value: Client): boolean => value?.name === LOCAL_VIDEO);

    if (!showScreenBroadcast.value) {
      showScreenBroadcast.value = true;
      interlocutor.value!.control!.showVideo = false;
      // (client as Client)!.control.showVideo = false;
      interlocutor.value!.mediaStream = await navigator.mediaDevices.getDisplayMedia(
        {video: true, audio: true}
      );
      // localMediaStream.value = await navigator.mediaDevices.getDisplayMedia({video: true, audio: true});
      interlocutor.value!.peerMediaElement!.srcObject = interlocutor.value!.mediaStream;
      // peerMediaElements.value['LOCAL_VIDEO'].srcObject = localMediaStream.value;
      interlocutor.value!.control!.showVideo = true;
      // (client as Client)!.control.showVideo = true;
    } else {
      interlocutor.value!.control!.showVideo = false;
      // (client as Client)!.control.showVideo = false;
      interlocutor.value!.mediaStream!.getTracks().forEach((track: MediaStreamTrack): void => track.stop());
      // localMediaStream.value!.getTracks().forEach((track: MediaStreamTrack): void => track.stop());
      await setLocalMediaStream();
      interlocutor.value!.peerMediaElement!.srcObject = interlocutor.value!.mediaStream!;
      // peerMediaElements.value['LOCAL_VIDEO'].srcObject = localMediaStream.value;
      interlocutor.value!.control!.showVideo = true;
      // (client as Client)!.control.showVideo = true;
      showScreenBroadcast.value = false;
    }

    updateInterlocutor(interlocutor.value!);
    // changingMediaStreamForPeers();
  }

  const handleHungUp = async (): Promise<void> => {
    await getInterlocutor(currentInterlocutor.value.code);

    await removeInterlocutor(interlocutor.value!.code);
    await leave();
    interlocutor.value!.mediaStream!.getTracks().forEach((track: MediaStreamTrack) => track.stop());
    // action(ACTIONS.LEAVE);
  }

  const handleRemovePeer = async ({interlocutorCode}: {interlocutorCode: string}): Promise<void> => {
    await getInterlocutor(interlocutorCode);

    if (interlocutor.value!.peerConnection) {
      interlocutor.value!.peerConnection.close();
    }

    delete interlocutor.value!.peerConnection;
    delete interlocutor.value!.peerMediaElement;
    delete interlocutor.value!.mediaStream;

    removeInterlocutor(interlocutorCode);
  }

  const handleNewCandidate = async (
    {
      interlocutorCode,
      iceCandidate
    }: {
      interlocutorCode: string,
      iceCandidate: RTCIceCandidate
    }
  ): Promise<void> => {
    await getInterlocutor(interlocutorCode);
    console.log('handleNewCandidate', iceCandidate);
    await interlocutor.value!.peerConnection!.addIceCandidate(
      new RTCIceCandidate(iceCandidate)
    );

    updateInterlocutor(interlocutor.value!);
  }

  onUpdated((): void => {
    console.log('update', interlocutors.value)
    // videos.value.forEach((video: HTMLVideoElement, index: number): void => {
    //   console.log('update', interlocutors.value)
    //   interlocutors.value[index].peerMediaElement = video;
    //   //peerMediaElements.value[`${clients.value[index]!.name}`] = video;
    //   // if (
    //   //   interlocutors.value[index].code === currentInterlocutor.value.code
    //   //   && !interlocutors.value[index].peerMediaElement!.srcObject
    //   //   // clients.value[index]!.name === LOCAL_VIDEO
    //   //   // && !peerMediaElements.value[LOCAL_VIDEO].srcObject
    //   // ) {
    //   //   console.log('update', interlocutors.value[index].peerMediaElement);
    //   //   interlocutors.value[index].peerMediaElement!.volume = 0;
    //   //   interlocutors.value[index].peerMediaElement!.srcObject = currentInterlocutor.value.mediaStream as MediaStream;
    //   //   // peerMediaElements.value[LOCAL_VIDEO].volume = 0;
    //   //   // peerMediaElements.value[LOCAL_VIDEO].srcObject = localMediaStream.value;
    //   //   return;
    //   // }
    //   if(
    //     !interlocutors.value[index].peerMediaElement!.srcObject
    //     // !peerMediaElements.value[clients.value[index]!.name].srcObject
    //   ) {
    //
    //     interlocutors.value[index].peerMediaElement!.srcObject = interlocutors.value[index].mediaStream as MediaStream;
    //     // peerMediaElements.value[clients.value[index]!.name].srcObject = clientsMediaStream.value[clients.value[index]!.name];
    //   }
    // })
  });

  onBeforeUnmount(async (): Promise<void> => {
    await handleHungUp();
  });


  // watch(roomID, (): void => {
  //   startCapture()
  //     .then(() => action(ACTIONS.JOIN, {room: roomID.value}))
  //     .catch((error) => console.error(`Error getting userMedia: ${error}`));
  // });
  watch(videos, () => {
    videos.value.forEach((video: HTMLVideoElement, index: number): void => {
      console.log('watch update', interlocutors.value)
      interlocutors.value[index].peerMediaElement = video;
      //peerMediaElements.value[`${clients.value[index]!.name}`] = video;
      // if (
      //   interlocutors.value[index].code === currentInterlocutor.value.code
      //   && !interlocutors.value[index].peerMediaElement!.srcObject
      //   // clients.value[index]!.name === LOCAL_VIDEO
      //   // && !peerMediaElements.value[LOCAL_VIDEO].srcObject
      // ) {
      //   console.log('update', interlocutors.value[index].peerMediaElement);
      //   interlocutors.value[index].peerMediaElement!.volume = 0;
      //   interlocutors.value[index].peerMediaElement!.srcObject = currentInterlocutor.value.mediaStream as MediaStream;
      //   // peerMediaElements.value[LOCAL_VIDEO].volume = 0;
      //   // peerMediaElements.value[LOCAL_VIDEO].srcObject = localMediaStream.value;
      //   return;
      // }
      if(
        !interlocutors.value[index].peerMediaElement!.srcObject
        // !peerMediaElements.value[clients.value[index]!.name].srcObject
      ) {

        interlocutors.value[index].peerMediaElement!.srcObject = interlocutors.value[index].mediaStream as MediaStream;
        // peerMediaElements.value[clients.value[index]!.name].srcObject = clientsMediaStream.value[clients.value[index]!.name];
      }
    })
  }, {
    deep: true
  });

  window.Echo.channel('videoMeeting')
    .listen(
      `.${room.value.name}.${ACTIONS.ADD_PEER}`,
      handleNewPeer
    ).listen(
      `.${room.value.name}.${ACTIONS.REMOVE_PEER}`,
      handleRemovePeer
    ).listen(
      `.${room.value.name}.${ACTIONS.MUTED}`,
      handleMutedClient
    ).listen(
      `${room.value.name}.${currentInterlocutor.value.code}.${ACTIONS.ICE_CANDIDATE}`,
      handleNewCandidate
    ).listen(
      `.${room.value.name}.${currentInterlocutor.value.code}.${ACTIONS.SESSION_DESCRIPTION}`,
      setRemoteMedia
    );
  console.log(window.Echo);

  // listenChannel(
  //   ACTIONS.ADD_PEER,
  //   handleNewPeer
  // ).listen(
  //   `.${room.value.name}.${ACTIONS.REMOVE_PEER}`,
  //   handleRemovePeer
  // ).listen(
  //   `.${room.value.name}.${ACTIONS.MUTED}`,
  //   handleMutedClient
  // );
  //
  // listenChannel(
  //   ACTIONS.ICE_CANDIDATE,
  //   handleNewCandidate,
  //   `${room.value.name}.${currentInterlocutor.value.code}`
  // ).listen(
  //   `.${room.value.name}.${currentInterlocutor.value.code}.${ACTIONS.SESSION_DESCRIPTION}`,
  //   setRemoteMedia
  // );

  //listen(ACTIONS.ADD_PEER, handleNewPeer);
  // listen(ACTIONS.SESSION_DESCRIPTION, setRemoteMedia);
  // listen(ACTIONS.ICE_CANDIDATE, handleNewCandidate);
  // listen(ACTIONS.REMOVE_PEER, handleRemovePeer);
  // listen(ACTIONS.MUTED, handleMutedClient)
  //listen(ACTIONS.MUTED_VIDEO_STREAM, handleMutedVideoClient)

  return {
    videos,
    // clients,
    showVideo,
    showAudio,
    audioOutputDevices,
    audioInputDevices,
    videoInputDevices,
    currentVideoInputDevices,
    currentAudioInputDevices,
    currentAudioOutputDevices,
    getInterlocutor,
    startCapture,
    handleMuteVideo,
    handleMuteAudio,
    handleScreenBroadcast,
    handleHungUp,
    setDevices
  }
}
