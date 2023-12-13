<script setup lang="ts">
import {ref, watch} from 'vue';
import Cropper from 'cropperjs';
import 'cropperjs/dist/cropper.css';
import Button from "primevue/button";

type TProps = {
  avatar: string
}

const props = defineProps<TProps>();

const emits = defineEmits<{
  (e: 'cansel'): void
  (e: 'accept', value: Blob): void
}>();

const image = ref<HTMLImageElement>();
const crop = ref<Cropper>();

watch(image, (value) => {
  if (value) {
    crop.value = new Cropper(image.value!);
  }
});

const handleCansel = () => {
  emits('cansel');
}

const handleAccept = () => {
  crop.value!.getCroppedCanvas().toBlob((value) => {
    emits('accept', value as Blob);
  });
}
</script>

<template>
  <div>
    <img ref="image" :src="avatar" alt="rrr">
  </div>
  <div
    class="flex justify-center gap-2 mt-4"
  >
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
.cropper-container {
  max-width: 500px;
  max-height: 500px;
}
</style>