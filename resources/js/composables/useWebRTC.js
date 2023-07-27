import {ref, watch, onUpdated, onBeforeUnmount} from "vue";
import ACTIONS from "../socket/actions.js";
import socket from "../socket/index.js";
import freeice from "freeice";

export const LOCAL_VIDEO = 'LOCAL_VIDEO';

export default function useWebRTC(id) {

  const roomID = ref(id);
  const localMediaStream = ref(null);
  const peerMediaElements = ref({});
  const peerConnections = ref({});
  const clients = ref([]);
  const clientsMediaStream = ref({});

  const videos = ref([]);

  /**
   *
   */
  const action = (action, data) => {
    data ? socket.emit(action, data) : socket.emit(action);
  }

  const addNewClient = (newClient) => {
    if (!clients.value.includes(newClient)) {
      clients.value = [...clients.value, newClient];
    }
  }

  const startCapture = async () => {
    localMediaStream.value = await navigator.mediaDevices.getUserMedia({
      audio: true,
      video: {
        width: 320,
        height: 300
      }
    });
    addNewClient(LOCAL_VIDEO);
  }
  const setRemoteMedia = async ({peerID, sessionDescription: remoteDescription}) => {
    await peerConnections.value[peerID].setRemoteDescription(
      new RTCSessionDescription(remoteDescription)
    );

    if (remoteDescription.type === 'offer') {
      const answer = await peerConnections.value[peerID].createAnswer();
      await peerConnections.value[peerID].setLocalDescription(answer);
      action(ACTIONS.RELAY_SDP, {
        peerID,
        sessionDescription: answer
      });
    }
  }

  const handleNewPeer = async ({peerID, createOffer}) => {
    if (peerID in peerConnections.value) {
      console.warn(`Already connected to peer ${peerID}`)
    }

    peerConnections.value[peerID] = new RTCPeerConnection({
      iceServers: freeice()
    })

    peerConnections.value[peerID].onicecandidate = (event) => {
      if (event.candidate) {
        action(ACTIONS.RELAY_ICE, {
          peerID,
          iceCandidate: event.candidate
        })
      }
    }

    let tracksNumber = 0; //two tracks, video + audio
    peerConnections.value[peerID].ontrack = ({streams: [remoteStream]}) => {
      tracksNumber++;
      if (tracksNumber === 2) {
        addNewClient(peerID);
        clientsMediaStream.value[peerID] = remoteStream;
      }
    }

    localMediaStream.value.getTracks().forEach((track) => {
      peerConnections.value[peerID].addTrack(track, localMediaStream.value)
    })

    if (createOffer) {
      const offer = await peerConnections.value[peerID].createOffer();
      await peerConnections.value[peerID].setLocalDescription(offer);
      action(ACTIONS.RELAY_SDP, {
        peerID,
        sessionDescription: offer
      });
    }
  }

  const handleRemovePeer = ({peerID}) => {
    if (peerConnections.value[peerID]) {
      peerConnections.value[peerID].close();
    }

    delete peerConnections.value[peerID];
    delete peerMediaElements.value[peerID];
    delete clientsMediaStream.value[peerID];

    clients.value = clients.value.filter((client) => client !== peerID);
  }

  const handleNewCandidate = ({peerID, iceCandidate}) => {
    peerConnections.value[peerID].addIceCandidate(
      new RTCIceCandidate(iceCandidate)
    );
  }

  onUpdated(() => {
    videos.value.forEach((video, index) => {
      peerMediaElements.value[`${clients.value[index]}`] = video;
      if (clients.value[index] === LOCAL_VIDEO && !peerMediaElements.value[LOCAL_VIDEO].srcObject) {
        peerMediaElements.value[LOCAL_VIDEO].volume = 0;
        peerMediaElements.value[LOCAL_VIDEO].srcObject = localMediaStream.value;
        return;
      }
      if(!peerMediaElements.value[clients.value[index]].srcObject) {
        peerMediaElements.value[clients.value[index]].srcObject = clientsMediaStream.value[clients.value[index]];
      }
    })
  });

  onBeforeUnmount(() => {
    localMediaStream.value.getTracks().forEach((track) => track.stop())
    action(ACTIONS.LEAVE);
  });

  watch(roomID, () => {
    startCapture()
      .then(() => action(ACTIONS.JOIN, {room: roomID.value}))
      .catch((error) => console.error(`Error getting userMedia: ${error}`));
  });

  return {
    videos,
    clients,
    startCapture,
    handleNewPeer,
    setRemoteMedia,
    handleRemovePeer,
    handleNewCandidate
  }
}
