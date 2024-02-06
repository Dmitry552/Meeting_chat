<script lang="ts" setup>
import {computed, toRef} from "vue";
import {Interlocutor} from '../types';
import {useStore} from "../store";
import useHeightCalculator from "../composables/useHeightCalculator";

type TVideoListProps = {
  getWidth: string,
  currentVideo: Interlocutor | null,
  videos: HTMLVideoElement[]
}

type TVideoListEmit = {
  (e: 'expandVideo', event: Event): void
}

const store = useStore();

const props = defineProps<TVideoListProps>();
const videos = toRef(props.videos);

const {
  screenElement
} = useHeightCalculator(videos);

const emit = defineEmits<TVideoListEmit>();

const interlocutors = computed<Interlocutor[]>(() => store.getters.getInterlocutorsRoom);

function handleExpandVideo(event: Event) {
  try {
    emit('expandVideo', event);
  } catch (err) {
    console.log('err', err)
  }
}
</script>

<template>
  <div
    :class="[currentVideo ? 'absolute bottom-0 left-0' : '',
      '2 w-full h-full flex content-around justify-around items-center flex-wrap my-3 px-3'
      ]"
    ref="screenElement"
  >
    <div
      :class="['relative overflow-hidden flex border-2 border-gray-300 dark:border-gray-500 items-stretch ',
            currentVideo
            ? 'rounded-full h-16 grow-0'
            : 'rounded-xl cursor-pointer'
          ]"
      v-for="interlocutor in interlocutors"
      :id="interlocutor!.code"
      :key="interlocutor!.code"
    >
      <video
        @click.stop="handleExpandVideo"
        class="block w-full h-full object-cover"
        id="media"
        ref="videos"
        autoplay
        playsinline
      />
      <div
        v-if="!interlocutor?.control?.showVideo"
        class="absolute top-0 left-0 w-full h-full bg-gray-100 dark:bg-gray-600"
      >
        <div
          class="w-full h-full flex justify-center items-center"
        >
          <svg
            class="h-40 w-40 text-gray-300 dark:text-gray-500"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            stroke-width="2"
            stroke="currentColor"
            fill="none"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <path stroke="none" d="M0 0h24v24H0z"/>
            <circle cx="12" cy="7" r="4" />
            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
          </svg>
        </div>
      </div>
      <div
        v-if="!interlocutor?.control?.showAudio"
        class="absolute rounded-full w-4 h-4 bottom-2 left-2"
      >
        <svg
          class="h-4 w-4 text-white"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <line x1="1" y1="1" x2="23" y2="23" />
          <path d="M9 9v3a3 3 0 0 0 5.12 2.12M15 9.34V4a3 3 0 0 0-5.94-.6" />
          <path d="M17 16.95A7 7 0 0 1 5 12v-2m14 0v2a7 7 0 0 1-.11 1.23" />
          <line x1="12" y1="19" x2="12" y2="23" />
          <line x1="8" y1="23" x2="16" y2="23" />
        </svg>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>