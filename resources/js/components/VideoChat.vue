<script lang="ts" setup>
import useWebRTC from "../composables/useWebRTC";
import {useRoute, useRouter} from "vue-router";
import VideoList from "../components/VideoList.vue";
import {getBlockWidth, getSubBlockWidth} from "../utils/getBlockWidth";
import ACTIONS from "../socket/actions";
// import useSocket from "../composables/useSocket";
import {computed, ref} from "vue";
import {Client, Clients, ControlStream, Interlocutor} from "../types";
import MeetingControl from "./MeetingControl.vue";
import swal from 'sweetalert';
import * as types from "../store/modules/Interlocutor/mutationsInterlocutorType";
import {useStore} from "../store";
import {
  setInterlocutors
} from '../store/modules/Interlocutor/mutations'

export type TCurrentVideo = {
  client: Client
}

const route = useRoute();
const {push} = useRouter();
const store = useStore();

const {
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
  startCapture,
  handleMuteVideo,
  handleMuteAudio,
  handleScreenBroadcast,
  handleHungUp,
  setDevices
} = useWebRTC();

const currentInterlocutor = computed<Interlocutor>(() => store.getters.getCurrentInterlocutor);
const interlocutors = computed<Interlocutor[]>(() => store.getters.getInterlocutorsRoom);

const joinAction = () => store.dispatch('joined');
const removeInterlocutor = (data: string) => store.dispatch('removeInterlocutor', data);

await startCapture().then(() => {
    console.log('startCapture');
    joinAction();
  }).catch((error) => {
    swal('Ops...', `${error}`, 'error');
    console.error(`Error getting userMedia: ${error}`)
  })

const currentVideo = ref<Interlocutor | null>(null);
// const currentVideo = ref<Client | null>(null);
// const allClients = ref<Clients>([]);
const allInterlocutors = ref<Interlocutor[]>([]);
const current_video = ref<HTMLVideoElement | null>(null);

function handleExpandVideo(event: Event) {
  let oldInterlocutor;
  // let oldClients: Clients;

  if (!currentVideo.value) {
    allInterlocutors.value = interlocutors.value;
    // allClients.value = clients.value;
  }

  if (!(currentVideo.value) || currentVideo.value?.code !== (event.target as HTMLVideoElement).id) {
    currentVideo.value = interlocutors.value!.find(
      interlocutor => interlocutor.code === (event.target as HTMLVideoElement).id
    ) as Interlocutor;
    // currentVideo.value = clients.value.find(client => client!.name === (event.target as HTMLVideoElement).id) as Client;
    console.log(current_video.value);
    if (currentVideo.value!.code === currentInterlocutor.value!.code) {
      current_video.value!.srcObject = currentInterlocutor.value!.mediaStream!;
    } else {
      current_video.value!.srcObject = currentVideo.value!.mediaStream!;
    }
    // if (currentVideo.value!.name === LOCAL_VIDEO) {
    //   current_video.value!.srcObject = localMediaStream.value;
    // } else {
    //   current_video.value!.srcObject = clientsMediaStream.value[currentVideo.value!.name];
    // }
  }

  oldInterlocutor = allInterlocutors.value.filter((interlocutor) => {
    return interlocutor!.code !== currentVideo.value!.code;
  });
  // oldClients = allClients.value.filter((client) => {
  //   return client!.name !== currentVideo.value!.name
  // });
  setInterlocutors(oldInterlocutor);
  // clients.value = [...oldClients];
}

async function handleLeavingMeeting() {
  await handleHungUp();
  await push('home');
}

function handleMinimizeVideo() {
  setInterlocutors(allInterlocutors.value);
  // clients.value = allClients.value;
  current_video.value!.srcObject = null;
  allInterlocutors.value = [];
  currentVideo.value = null;
}

function handleChangeDevice(option: {id: string, name: string}) {
  setDevices(option)
}

const getWidth = computed<string>(() => {
  if (currentVideo.value) {
    return getSubBlockWidth(interlocutors.value.length)
    // return getSubBlockWidth(clients.value.length)
  } else {
    return getSubBlockWidth(interlocutors.value.length)
    // return getBlockWidth(clients.value.length)
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
          :id="currentVideo?.code"
        >
          <video
            class="block h-full rounded-xl border-2 border-gray-300 dark:border-gray-500"
            :id="currentVideo?.code"
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