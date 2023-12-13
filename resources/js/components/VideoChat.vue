<script lang="ts" setup>
import useWebRTC, {LOCAL_VIDEO} from "../composables/useWebRTC";
import {useRoute, useRouter} from "vue-router";
import VideoList from "../components/VideoList.vue";
import {getBlockWidth, getSubBlockWidth} from "../utils/getBlockWidth";
import ACTIONS from "../socket/actions";
import useSocket from "../composables/useSocket";
import {computed, ref} from "vue";
import {Client, Clients} from "../types";
import MeetingControl from "./MeetingControl.vue";
import swal from 'sweetalert';

export type TCurrentVideo = {
  client: Client
}

const route = useRoute();
const router = useRouter();

const {action} = useSocket();

const {
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
} = useWebRTC(route.params.id as string);


startCapture()
  .then(() => {
    action(ACTIONS.JOIN, {room: route.params.id as string})
  })
  .catch((error) => {
    showVideo.value = false;
    showAudio.value = false;
    addNewClient(LOCAL_VIDEO);
    swal('Ops...', `${error}`, 'error');
    console.error(`Error getting userMedia: ${error}`)
  })

const currentVideo = ref<Client | null>(null);
const allClients = ref<Clients>([]);
const current_video = ref<HTMLVideoElement | null>(null);

function handleExpandVideo(event: Event) {
  let oldClients: Clients;

  if (!currentVideo.value) {
    allClients.value = clients.value;
  }

  if (!(currentVideo.value) || currentVideo.value?.name !== (event.target as HTMLVideoElement).id) {
    currentVideo.value = clients.value.find(client => client!.name === (event.target as HTMLVideoElement).id) as Client;
    console.log(current_video.value);
    if (currentVideo.value!.name === LOCAL_VIDEO) {
      current_video.value!.srcObject = localMediaStream.value;
    } else {
      current_video.value!.srcObject = clientsMediaStream.value[currentVideo.value!.name];
    }
  }

  oldClients = allClients.value.filter((client) => {
    return client!.name !== currentVideo.value!.name
  });

  clients.value = [...oldClients];
}

function handleLeavingMeeting() {
  handleHungUp();
  router.push('/');
}

function handleMinimizeVideo() {
  clients.value = allClients.value;
  current_video.value!.srcObject = null;
  allClients.value = [];
  currentVideo.value = null;
}

function handleChangeDevice(option: {id: string, name: string}) {
  setDevices(option)
}

const getWidth = computed<string>(() => {
  if (currentVideo.value) {
    return getSubBlockWidth(clients.value.length)
  } else {
    return getBlockWidth(clients.value.length)
  }
});
</script>

<template>
  <div
    class="mt-[43px] w-full flex flex-col items-end relative"
  >
    <div
      v-show="currentVideo"
      class="1 w-full h-full pb-2 flex justify-center grow"
    >
      <div class="relative w-full flex justify-center">
        <div
          class="w-full overflow-hidden flex justify-center
            items-center"
          :id="currentVideo?.name"
        >
          <video
            class="block h-full rounded-xl border-2 border-gray-300 dark:border-gray-500"
            :id="currentVideo?.name"
            ref="current_video"
            autoplay
            playsinline
          />
        </div>
        <div
          @click="handleMinimizeVideo"
          class="1.1 absolute top-4 right-4 cursor-pointer z-10"
        >
          <svg
            class="transition-all duration-100 scale-100 w-5 h-5 text-gray-800 dark:text-gray-500 hover:scale-95"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 18 18"
          >
            <path
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M13 17v-4h4M1 5h4V1M1 13h4v4m8-16v4h4"
            />
          </svg>
        </div>
      </div>
    </div>
    <video-list
      v-show="!currentVideo"
      :getWidth="getWidth"
      :currentVideo="currentVideo"
      :clients="clients"
      :videos="videos"
      @expandVideo="handleExpandVideo"
    />
    <meeting-control
      v-show="!currentVideo"
      :showVideo="showVideo"
      :showAudio="showAudio"
      :audioOutputDevices="audioOutputDevices"
      :audioInputDevices="audioInputDevices"
      :videoInputDevices="videoInputDevices"
      :currentVideoInputDevices="currentVideoInputDevices!"
      :currentAudioInputDevices="currentAudioInputDevices!"
      :currentAudioOutputDevices="currentAudioOutputDevices!"
      @muteAudio="handleMuteAudio"
      @muteVideo="handleMuteVideo"
      @screenBroadcast="handleScreenBroadcast"
      @leavingMeeting="handleLeavingMeeting"
      @changeDevice="handleChangeDevice"
    />
  </div>
</template>

<style scoped>

</style>