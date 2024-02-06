import {ref, onBeforeUnmount, computed, watch} from "vue";
import ACTIONS from "../socket/actions";
import freeice from "freeice";
import {TDevice, Interlocutor, Room} from "../types";
import {getFilteredDevices} from "../utils/helpers";
import {useStore} from "../store";
import {translationIce} from "../store/modules/VideoChat/actions";
import {TMuteData, TTranslationIceData, TTranslationSpdData} from "../store/modules/VideoChat/types";
import {getInterlocutor} from "../store/modules/Interlocutor/actions";
import {
  updateInterlocutor,
  removeInterlocutor, removeInterlocutors
} from '../store/modules/Interlocutor/mutations'

export default function useWebRTC() {

  const store = useStore();

  const interlocutor = ref<Interlocutor>(); //+
  const negotiationNeeded = ref<boolean>(false); //+

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

    navigator.mediaDevices.ondevicechange = async (): Promise<void> => {
      await getDevises();
    }

    await setLocalMediaStream();
    await getDevises();

    interlocutor.value!.control = {
      showAudio: true,
      showVideo: true
    }

    updateInterlocutor(interlocutor.value as Interlocutor);
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

  const changingMediaStreamForPeers = (): void => {
    negotiationNeeded.value = true;

    interlocutors.value!.forEach((_interlocutor: Interlocutor) => {
      const tracks: MediaStreamTrack[] = interlocutor.value!.mediaStream!.getTracks();
      const senders: RTCRtpSender[] = _interlocutor.peerConnection!.getSenders();
      senders.forEach((sender: RTCRtpSender): void => {
        _interlocutor.peerConnection!.removeTrack(sender!);
      });

      tracks.forEach((track: MediaStreamTrack): void => {
        if (track.kind === 'video') {
          track.enabled = showVideo.value
        } else if (track.kind === 'audio') {
          track.enabled = showAudio.value
        }

        _interlocutor.peerConnection!.addTrack(
          track,
          (interlocutor.value!.mediaStream as MediaStream)
        );
      })
    })
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

  const negotiation = async (interlocutorCode: string, newInterlocutor: boolean = false): Promise<void> => {
    if (newInterlocutor) {
      await getInterlocutor(interlocutorCode);
    }

    const offer: RTCSessionDescriptionInit = await interlocutor.value!.peerConnection!.createOffer();
    await interlocutor.value!.peerConnection!.setLocalDescription(offer);

    await translationSdp({
      interlocutorCode,
      sessionDescription: offer
    });
  }

  const setRemoteMedia = async (
    {
      interlocutorCode,
      sessionDescription: remoteDescription
    }: {
      interlocutorCode: string,
      sessionDescription: RTCSessionDescriptionInit
    }
  ): Promise<void> => {
    remoteDescription.sdp += '\r\n';
    await getInterlocutor(interlocutorCode);
    await interlocutor.value!.peerConnection!.setRemoteDescription(
      new RTCSessionDescription(remoteDescription)
    );

    if (remoteDescription.type === 'offer') {
      const answer: RTCSessionDescriptionInit = await interlocutor.value!.peerConnection!.createAnswer();
      await interlocutor.value!.peerConnection!.setLocalDescription(answer);

      await translationSdp({
        interlocutorCode,
        sessionDescription: answer
      });
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
    await getInterlocutor(interlocutorCode);
    let localInterlocutor: Interlocutor;

    if (interlocutor.value!.peerConnection) {
      console.warn(`Already connected to peer ${interlocutorCode}`)
    }

    if (interlocutor.value!.code !== currentInterlocutor.value.code) {
      interlocutor.value!.control = {
        showAudio: true,
        showVideo: false
      }
      localInterlocutor = interlocutors.value.find(
        (interlocutor: Interlocutor): boolean => interlocutor.code === currentInterlocutor.value.code
      ) as Interlocutor;
    } else {
      localInterlocutor = interlocutor.value as Interlocutor;
    }

    interlocutor.value!.peerConnection = new RTCPeerConnection({
      iceServers: freeice()
    })

    interlocutor.value!.peerConnection!.onicecandidate = async (event: RTCPeerConnectionIceEvent): Promise<void> => {
      if (event.candidate) {
        await translationIce({
          interlocutorCode,
          iceCandidate: event.candidate
        })
      }
    }

    let track: number = 0;
    interlocutor.value!.peerConnection!.ontrack = (event: RTCTrackEvent): void => {
      ++track;
      if (track >= 2) {
        interlocutor.value!.mediaStream = event.streams[0];
        interlocutor.value!.peerMediaElement!.srcObject = interlocutor.value!.mediaStream;
        interlocutor.value!.control!.showVideo = true;
      }
    }

    localInterlocutor.mediaStream!.getTracks().forEach((track: MediaStreamTrack): void => {
      interlocutor.value!.peerConnection!.addTrack(track, localInterlocutor.mediaStream!)
    })

    interlocutor.value!.peerConnection!.onnegotiationneeded = async (): Promise<void> => {
      if (negotiationNeeded.value) {
        await negotiation(interlocutorCode, true);
        negotiationNeeded.value = false;
      }
    }

    if (createOffer && interlocutor.value!.code !== currentInterlocutor.value!.code) {
      await negotiation(interlocutorCode);
    }

    updateInterlocutor(interlocutor.value as Interlocutor);
  }

  const handleMuteVideo = async (): Promise<void> => {
    await getInterlocutor(currentInterlocutor.value.code);

    if (showVideo.value) {
      showVideo.value = false;
      interlocutor.value!.control!.showVideo = false;
      await setLocalMediaStream('audio');
      await muteStream({
          interlocutorCode: currentInterlocutor.value!.code,
          value: false,
          key: 'video'
        }
      );

    } else {
      await setLocalMediaStream();
      interlocutor.value!.peerMediaElement!.srcObject = interlocutor.value!.mediaStream as MediaStream;
      showVideo.value = true;
      interlocutor.value!.control!.showVideo = true;
      await muteStream({
          interlocutorCode: currentInterlocutor.value!.code,
          value: true,
          key: 'video'
        }
      );
    }
  }

  const handleMuteAudio = async (): Promise<void> => {
    await getInterlocutor(currentInterlocutor.value.code);

    if (showAudio.value) {
      showAudio.value = false;
      interlocutor.value!.control!.showAudio = false;
      interlocutor.value!.mediaStream!.getAudioTracks()[0].enabled = false;
      await muteStream({
          interlocutorCode: currentInterlocutor.value!.code,
          value: false,
          key: 'audio'
        }
      );
    } else {
      showAudio.value = true;
      interlocutor.value!.control!.showAudio = true;
      interlocutor.value!.mediaStream!.getAudioTracks()[0].enabled = true;
      await muteStream({
          interlocutorCode: currentInterlocutor.value!.code,
          value: true,
          key: 'audio'
        }
      );
    }

    updateInterlocutor(interlocutor.value!)
  }

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

    if (key === 'audio') {
      interlocutor.value!.control!.showAudio = value;
      interlocutor.value!.mediaStream!.getAudioTracks()[0].enabled = value;
    } else {
      interlocutor.value!.control!.showVideo = value;
      interlocutor.value!.mediaStream!.getVideoTracks()[0].enabled = value;
    }

    updateInterlocutor(interlocutor.value!);
  }

  const handleScreenBroadcast = async (): Promise<void> => {
    await getInterlocutor(currentInterlocutor.value!.code);

    if (!showScreenBroadcast.value) {
      showScreenBroadcast.value = true;
      interlocutor.value!.control!.showVideo = false;
      interlocutor.value!.mediaStream = await navigator.mediaDevices.getDisplayMedia(
        {video: true, audio: true}
      );
      interlocutor.value!.peerMediaElement!.srcObject = interlocutor.value!.mediaStream;
      interlocutor.value!.control!.showVideo = true;
    } else {
      interlocutor.value!.control!.showVideo = false;
      interlocutor.value!.mediaStream!.getTracks().forEach((track: MediaStreamTrack): void => track.stop());
      await setLocalMediaStream();
      interlocutor.value!.peerMediaElement!.srcObject = interlocutor.value!.mediaStream!;
      interlocutor.value!.control!.showVideo = true;
      showScreenBroadcast.value = false;
    }

    updateInterlocutor(interlocutor.value!);
    changingMediaStreamForPeers();
  }

  const handleHungUp = async (): Promise<void> => {
    await getInterlocutor(currentInterlocutor.value.code);
    interlocutor.value!.mediaStream!.getTracks().forEach((track: MediaStreamTrack) => track.stop());
    await leave();
    window.Echo.leaveChannel(`videoMeeting.${room.value.name}`);
    window.Echo.leaveChannel(`videoMeeting.${room.value.name}.${interlocutor.value!.code}`);
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
    await interlocutor.value!.peerConnection!.addIceCandidate(
      new RTCIceCandidate(iceCandidate)
    );
  }

  onBeforeUnmount((): void => {
    handleHungUp().then(() => {
      removeInterlocutors();
      if (localStorage.getItem('currentInterlocutor')) {
        localStorage.removeItem('currentInterlocutor');
      }
    });
  });

  watch(videos, () => {
    videos.value.forEach((video: HTMLVideoElement, index: number): void => {
      interlocutors.value[index].peerMediaElement = video;
      interlocutors.value[index].peerMediaElement!.srcObject = interlocutors.value[index].mediaStream as MediaStream;

      if (interlocutors.value[index].code === currentInterlocutor.value.code) {
      }
    })
  }, {
    deep: true
  });

  window.Echo.channel(`videoMeeting.${room.value.name}`)
    .listen(
      `.${ACTIONS.REMOVE_PEER}`,
      handleRemovePeer
    ).listen(
      `.${ACTIONS.MUTED}`,
      handleMutedClient
    );

  window.Echo.channel(`videoMeeting.${room.value.name}.${currentInterlocutor.value.code}`)
    .listen(
      `.${ACTIONS.ADD_PEER}`,
      handleNewPeer
    ).listen(
      `.${ACTIONS.ICE_CANDIDATE}`,
      handleNewCandidate
    ).listen(
      `.${ACTIONS.SESSION_DESCRIPTION}`,
      setRemoteMedia
    );

  return {
    videos,
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
    setDevices
  }
}
