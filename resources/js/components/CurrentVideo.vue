<script setup lang="ts">
import {Client} from "../types";
import {ref} from "vue";

const video = ref<HTMLVideoElement>();

const props = defineProps<{currentVideo: Client}>();

const emits = defineEmits<{
  (e: 'minimizeVideo'): void
}>();

function handleMinimizeVideo() {
  emits('minimizeVideo');
}
</script>

<template>
  <div
    v-if="props.currentVideo"
    class="1 w-full border-b-2 border-b-gray-300 dark:border-b-gray-500 pb-2 flex justify-center"
  >
    <div class="relative w-full max-w-3xl flex justify-center">
      <div
        class="w-full rounded-xl overflow-hidden flex border-2 border-gray-300 dark:border-gray-500
          items-center sm:border-red-600 md:max-w-xl lg:max-w-2xl"
        :id="props.currentVideo.name"
      >
        <video
          :src="props.currentVideo.stream"
          class="block w-full"
          :id="props.currentVideo.name"
          ref="videos"
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
</template>

<style scoped>

</style>