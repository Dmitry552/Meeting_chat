<template>
  <h1>Available rooms</h1>
  <ul>
    <li v-for="roomID in rooms" :key="roomID">
      {{ roomID }}
      <button @click="$router.push(`/room/${roomID}`)">JOIN ROOM</button>
    </li>
  </ul>
  <button @click="handleCreateNewRoom">Create new room</button>
</template>

<script>
import AddLayoutMixin from "../mixins/AddLayoutMixin";
import {v4} from 'uuid';
import socket from '../socket';
import ACTIONS from "../socket/actions.js";

export default {
  name: "Home",
  mixins: [AddLayoutMixin],
  data() {
    return {
      layoutName: 'main',
      rooms: [],
    }
  },
  methods: {
    handleCreateNewRoom() {
      const roomID = v4();
      this.$router.push(`/room/${roomID}`);
    },
  },
  computed: {
    socket() {
      return socket;
    }
  },
  created() {
    this.socket.on(ACTIONS.SHARE_ROOMS, ({rooms = []}) => {
      this.rooms = rooms;
    })
  }
}
</script>

<style scoped>

</style>