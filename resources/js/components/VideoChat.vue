<template>
  <div class="grow flex justify-center">
    <div v-for="clientID in clients">
      <video
        :key="clientID"
        id="clientID"
        ref="videos"
        autoplay
        playsinline
      />
    </div>
  </div>
</template>

<script>
import useWebRTC from "../composables/useWebRTC.js";
import socket from "../socket/index.js";
import ACTIONS from "../socket/actions.js";
import {useRoute} from "vue-router";

export default {
  name: "VideoChat",
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
  mixins: [],
  components: [],
  props: {},
  data() {
    return {
      //clients: [1, 2, 3],
    }
  },
  methods: {},
  computed: {},
  watch: {}
}
</script>

<style scoped>

</style>