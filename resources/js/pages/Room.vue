<template>
  <div
    class="flex w-full h-full justify-between relative"
  >
    <client-list :showClientList="showClientList" @hidingClientList="handleShowClientList"/>
    <video-chat/>
    <text-chat :showChat="showChat" @hidingShowChat="handleShowChat"/>
    <div class="absolute top-o left-0 flex items-center h-full">
      <div
        @click="handleShowClientList"
        :class="['transition-all ease-in-out duration-300 relative h-14 w-32 bg-white rounded-r-full cursor-pointer',
            'flex items-center shadow-md shadow-gray-300 hover:bg-gray-300',
            showClientList ? '-translate-x-36' : '-translate-x-20 hover:-translate-x-16']"
      >
        <svg
          class="absolute w-6 h-full text-gray-500 dark:text-white right-4"
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 17 14"
        >
          <path
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M1 1h15M1 7h15M1 13h15"
          />
        </svg>
      </div>
    </div>
    <div class="absolute top-o right-0 flex items-center h-full">
      <div
        @click="handleShowChat"
        :class="['transition-all ease-in-out duration-300 relative h-14 w-32 bg-white rounded-l-full cursor-pointer',
          'flex items-center shadow-md shadow-gray-300 hover:bg-gray-300',
          showChat ? 'translate-x-36' : 'translate-x-20 hover:translate-x-16']"
      >
        <svg
          class="absolute w-6 h-full text-gray-500 dark:text-white left-4"
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg"
          width="16"
          height="12"
          fill="none"
          viewBox="0 0 16 12"
        >
          <path
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M1 1h14M1 6h14M1 11h7"
          />
        </svg>
      </div>
    </div>
  </div>
</template>

<script>
import AddLayoutMixin from "../mixins/AddLayoutMixin";
import ClientList from "../components/ClientList.vue";
import TextChat from "../components/TextChat.vue";
import VideoChat from "../components/VideoChat.vue";

export default {
  name: "Room",
  mixins: [AddLayoutMixin],
  components: {ClientList, TextChat, VideoChat},
  data() {
    return {
      layoutName: 'login',
      showClientList: false,
      showChat: false
    }
  },
  methods: {
    handleShowClientList() {
      this.showClientList = !this.showClientList;
    },
    handleShowChat() {
      this.showChat = !this.showChat;
    }
  },
}
</script>

<style scoped>

</style>