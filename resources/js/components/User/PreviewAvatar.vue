<script setup lang="ts">
import Button from "primevue/button";

type TProps = {
  previewAvatar: string | undefined
}

const props = defineProps<TProps>();

const emits = defineEmits<{
  (e: 'showUploadAvatar'): void,
  (e: 'showCropperAvatar'): void,
  (e: 'accept'): void
  (e: 'cansel'): void
}>();

const handleShowCropperAvatar = () => {
  emits('showCropperAvatar');
}

const handleShowUploadAvatar = () => {
  emits('showUploadAvatar');
}

const handleCansel = () => {
  emits('cansel');
}

const handleAccept = () => {
  emits('accept');
}
</script>

<template>
  <div class="overflow-hidden max-w-md max-h-md bg-gray-100 flex justify-center">
    <img v-if="props.previewAvatar" :src="props.previewAvatar" alt="avatar" class="h-full w-auto mx-auto">
    <svg
      v-else
      class="h-24 w-24 text-gray-300 dark:text-gray-500"
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
  <div
    class="flex justify-center gap-2 mt-4"
  >
    <Button
      class="w-full px-5 py-2.5 text-center text-white bg-blue-700 border border-blue-700 rounded-md text-sm
        mx-auto hover:bg-blue-800 shadow-lg font-semibold dark:bg-blue-950 dark:border-blue-950
        dark:hover:bg-blue-900 dark:hover:border-blue-900 dark:text-gray-300 disabled:bg-gray-500
        disabled:border-gray-500 dark:disabled:dg-gray-500 dark:disabled:border-gray-500
        dark:disabled:hover:border-gray-500 flex justify-center"
      @click="handleShowUploadAvatar"
    >
      <svg
        class="h-6 w-6 text-white"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
      >
        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
        <polyline points="7 10 12 15 17 10" />
        <line x1="12" y1="15" x2="12" y2="3" />
      </svg>
    </Button>
    <Button
      v-if="props.previewAvatar"
      class="w-full px-5 py-2.5 text-center text-white bg-blue-700 border border-blue-700 rounded-md text-sm
        mx-auto hover:bg-blue-800 shadow-lg font-semibold dark:bg-blue-950 dark:border-blue-950
        dark:hover:bg-blue-900 dark:hover:border-blue-900 dark:text-gray-300 disabled:bg-gray-500
        disabled:border-gray-500 dark:disabled:dg-gray-500 dark:disabled:border-gray-500
        dark:disabled:hover:border-gray-500 flex justify-center"
      @click="handleShowCropperAvatar"
    >
      <svg
        class="h-6 w-6 text-witw"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
      >
        <path d="M6.13 1L6 16a2 2 0 0 0 2 2h15" />
        <path d="M1 6.13L16 6a2 2 0 0 1 2 2v15" />
      </svg>
    </Button>
    <Button
      class="w-full px-5 py-2.5 text-center text-white bg-blue-700 border border-blue-700 rounded-md text-sm
        mx-auto block hover:bg-blue-800 shadow-lg font-semibold dark:bg-blue-950 dark:border-blue-950
        dark:hover:bg-blue-900 dark:hover:border-blue-900 dark:text-gray-300 disabled:bg-gray-500
        disabled:border-gray-500 dark:disabled:dg-gray-500 dark:disabled:border-gray-500
        dark:disabled:hover:border-gray-500"
      @click="handleAccept"
    >Ok</Button>
    <Button
      class="w-full px-5 py-2.5 text-center text-white bg-blue-700 border border-blue-700 rounded-md text-sm
        mx-auto block hover:bg-blue-800 shadow-lg font-semibold dark:bg-blue-950 dark:border-blue-950
        dark:hover:bg-blue-900 dark:hover:border-blue-900 dark:text-gray-300 disabled:bg-gray-500
        disabled:border-gray-500 dark:disabled:dg-gray-500 dark:disabled:border-gray-500
        dark:disabled:hover:border-gray-500"
      @click="handleCansel"
    >Cancel</Button>
  </div>
</template>

<style scoped>

</style>