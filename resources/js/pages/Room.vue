<template>
  <div v-for="clientID in clients">
    <video
        :key="clientID"
        ref="videos"
        autoplay
        playsinline
    />
  </div>

  Room
  {{ $route.params.id }}
</template>

<script>
import AddLayoutMixin from "../mixins/AddLayoutMixin";
import useWebRTC from "../composables/useWebRTC.js";
import socket from "../socket/index.js";
import ACTIONS from "../socket/actions.js";
import {useRoute} from "vue-router";

export default {
  name: "Room",
  mixins: [AddLayoutMixin],
  setup() {
    const route = useRoute();
    const {
      videos,
      clients,
      startCapture,
      handleNewPeer,
      setRemoteMedia,
      handleRemovePeer,
      handleNewCandidate
    } = useWebRTC(route.params.id);

    startCapture()
        .then(() => {
          socket.emit(ACTIONS.JOIN, {room: route.params.id});
        })
        .catch((error) => console.error(`Error getting userMedia: ${error}`))

    socket.on(ACTIONS.ADD_PEER, handleNewPeer);
    socket.on(ACTIONS.SESSION_DESCRIPTION, setRemoteMedia);
    socket.on(ACTIONS.ICE_CANDIDATE, handleNewCandidate);
    socket.on(ACTIONS.REMOVE_PEER, handleRemovePeer);

    return {
      videos,
      clients
    }
  },
  data() {
    return {
      layoutName: 'main',
    }
  },
}
</script>

<style scoped>

</style>