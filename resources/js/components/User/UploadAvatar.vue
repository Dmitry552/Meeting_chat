<script setup lang="ts">
import {computed, onBeforeUnmount} from "vue";
import { Dashboard } from '@uppy/vue';
import Uppy from '@uppy/core';
import XHR from '@uppy/xhr-upload';
import Button from "primevue/button";
import swal from "sweetalert";

const TUS_ENDPOINT = `${import.meta.env.VITE_APP_URL}/api/user/avatar`;

const emits = defineEmits<{
  (e: 'cansel'): void
  (e: 'accept'): void
}>();

const uppy = computed(() => new Uppy({
  id: 'uppy',
  autoProceed: false,
  debug: true,
  restrictions: {
    maxFileSize: 2097152,
    allowedFileTypes: ['.jpg', '.jpeg', '.png', '.bmp']
  }
}).use(XHR, {
    endpoint: TUS_ENDPOINT,
    limit: 1,
    formData: true,
    fieldName: 'avatar',
    headers: {
      authorization: `Bearer ${localStorage.getItem('token')}`,
    }
  })
);

uppy.value.on('complete', () => {
  emits('accept');
});

uppy.value.on('error', (error) => {
  swal({
    title: "Ops!",
    text: error.stack,
    icon: "warning",
  }).then(() => {
    emits('cansel');
  });
});

const handleClose = () => {
  emits('cansel');
}

onBeforeUnmount(() => {
  uppy.value.close();
});
</script>

<template>
  <div>
    <Dashboard
      :uppy="uppy"
      :props="{
          metaFields: [{ id: 'name', name: 'Name', placeholder: 'File name' }]
        }"
    />
  </div>
  <div>
    <Button
      class="w-full px-5 py-2.5 text-center text-white bg-blue-700 border border-blue-700 rounded-md text-sm
        mx-auto block hover:bg-blue-800 shadow-lg font-semibold dark:bg-blue-950 dark:border-blue-950
        dark:hover:bg-blue-900 dark:hover:border-blue-900 dark:text-gray-300 disabled:bg-gray-500
        disabled:border-gray-500 dark:disabled:dg-gray-500 dark:disabled:border-gray-500
        dark:disabled:hover:border-gray-500"
      @click="handleClose"
    >Cancel</Button>
  </div>
</template>

<style src="@uppy/core/dist/style.css"></style>
<style src="@uppy/dashboard/dist/style.css"></style>