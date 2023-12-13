<script setup lang="ts">
import {computed, ref, watch, toRef} from 'vue';
import { useConfirm } from "primevue/useconfirm";
import ConfirmDialog from 'primevue/confirmdialog';
import Skeleton from 'primevue/skeleton';
import CropperAvatar from "./CropperAvatar.vue";
import UploadAvatar from "./UploadAvatar.vue";
import {useStore} from "../../store";
import {errorHandler} from "../../utils/helpers";

type TProps = {
  currentUser: boolean
}

const confirm = useConfirm();
const store = useStore();

const showUploadAvatar = ref<boolean>(false);
const showCropperAvatar = ref<boolean>(false);

const previewAvatar = ref<string>();

const user = computed(() => store.getters.getUser);

const props = defineProps<TProps>();

watch(() => user, () => {
  previewAvatar.value = user.value!.avatarPath;
});

const newAvatar = (data: FormData) => store.dispatch('uploadAvatar', data);
const getUser = (data: string) => store.dispatch('getUser', data);

const handleCropperAvatar = () => {
  showCropperAvatar.value = true;
  confirm.require({
    group: "avatar",
  });
}

const handleNewAvatar = () => {
  showUploadAvatar.value = true;
  confirm.require({
    group: "avatar",
  });
}

const handleChangedNewAvatar = (callback: Function, value: Blob) => {
  const formData =  new FormData();
  formData.append('avatar', value);
  newAvatar(formData).catch(error => {
    errorHandler(error);
  });
  callback();
}

const handleAcceptChangeAvatar = (callback: Function) => {
  getUser((user.value.id as string)).catch(err => {
    errorHandler(err);
  });

  callback();
}
</script>

<template>
  <div class="bg-white p-3 border-t-4 border-blue-400">
    <div class="image overflow-hidden relative">
      <div class="w-56 h-56 bg-gray-100 mx-auto rounded-lg flex justify-center items-center">
        <img
          v-if="user?.avatarPath"
          class="h-full w-auto mx-auto"
          :src="user?.avatarPath"
          alt=""
        >
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
<!--      Cropped avatar-->
      <div
        v-if="props.currentUser"
        @click="handleNewAvatar"
        class="absolute bottom-1 right-1 border border-blue-700 rounded-md bg-blue-700 p-1 cursor-pointer
          hover:border-blue-800 hover:bg-blue-800"
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
      </div>
<!--      Upload new avatar-->
      <div
        v-if="props.currentUser"
        @click="handleCropperAvatar"
        class="absolute bottom-1 left-1 border border-blue-700 rounded-md bg-blue-700 p-1 cursor-pointer
          hover:border-blue-800 hover:bg-blue-800"
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
          <path d="M6.13 1L6 16a2 2 0 0 0 2 2h15" />
          <path d="M1 6.13L16 6a2 2 0 0 1 2 2v15" />
        </svg>
      </div>
    </div>
    <h1
      v-if="user"
      class="text-gray-900 font-bold text-xl leading-8 my-1"
    >
      {{user?.firstName}} {{user?.lastName}}
    </h1>
    <Skeleton v-else width="10rem" height="30px" class="mt-2"/>
    <ConfirmDialog group="avatar">
      <template #container="{ acceptCallback, rejectCallback }">
        <div class="p-5 surface-overlay border-round bg-white rounded-lg">
          <cropper-avatar
            v-if="showCropperAvatar"
            :avatar="previewAvatar!"
            @cansel="() => {
              showCropperAvatar = false;
              rejectCallback();
            }"
            @accept="(value) => {
              showCropperAvatar = false;
              handleChangedNewAvatar(acceptCallback, value);
            }"
          />
          <upload-avatar
            v-if="showUploadAvatar"
            @cansel="() => {
              showUploadAvatar = false;
              rejectCallback();
            }"
            @accept="() => {
              showUploadAvatar = false;
              handleAcceptChangeAvatar(acceptCallback);
            }"
          />
        </div>
      </template>
    </ConfirmDialog>
  </div>
</template>

<style scoped>

</style>