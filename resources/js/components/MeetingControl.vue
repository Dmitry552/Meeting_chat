<script setup lang="ts">
import {ref} from "vue";
import ControlElement from "./ControlElement.vue";

import microphoneOn from '../../images/MeetingControl/microphoneOn.svg';
import microphoneOff from '../../images/MeetingControl/microphoneOff.svg';
import earphone from '../../images/MeetingControl/earphone.svg';
import camcorderOn from '../../images/MeetingControl/camcorderOn.svg';
import camcorderOff from '../../images/MeetingControl/camcorderOff.svg';

type TMeetingControl = {
  showAudio: boolean,
  showVideo: boolean,
  audioOutputDevices: MediaDeviceInfo[],
  audioInputDevices: MediaDeviceInfo[],
  videoInputDevices: MediaDeviceInfo[],
  currentVideoInputDevices: MediaDeviceInfo,
  currentAudioInputDevices: MediaDeviceInfo,
  currentAudioOutputDevices: MediaDeviceInfo
}

const showAudioInputDevices = ref<boolean>(false);
const showAudioOutputDevices = ref<boolean>(false);
const showVideoInputDevices = ref<boolean>(false);

const props = defineProps<TMeetingControl>();

const emits = defineEmits<{
  (e: 'muteAudio'): void,
  (e: 'muteVideo'): void,
  (e: 'screenBroadcast'): void,
  (e: 'leavingMeeting'): void,
  (e: 'changeDevice', {id, name}: {id: string, name: string}): void
}>();

function handleMuteAudio() {
  emits('muteAudio');
}

function handleMuteVideo() {
  emits('muteVideo');
}

function handleScreenBroadcast() {
  emits('screenBroadcast');
}

function handleLeavingMeeting() {
  emits('leavingMeeting');
}

function handleShowDevice(deviceKind: string) {
  switch (deviceKind) {
    case 'audioinput':
      showAudioInputDevices.value = !showAudioInputDevices.value;
      showAudioOutputDevices.value = false;
      showVideoInputDevices.value = false;
      break;
    case 'videoinput':
      showVideoInputDevices.value = !showVideoInputDevices.value;
      showAudioInputDevices.value = false;
      showAudioOutputDevices.value = false;
      break;
    case 'audiooutput':
      showAudioOutputDevices.value = !showAudioOutputDevices.value;
      showAudioInputDevices.value = false;
      showVideoInputDevices.value = false;
      break;
  }
}

function handleChangeDevice(value: HTMLInputElement) {
  emits(
    'changeDevice',
    {id: value.value, name: value.name}
  )

  showAudioInputDevices.value = false;
  showAudioOutputDevices.value = false;
  showVideoInputDevices.value = false;
}
</script>

<template>
  <div class="3 bottom-0 w-full bg-gray-300">
    <div class="h-16 flex justify-center items-center gap-4 grow-0">
      <control-element
        deviceKind="audioinput"
        :alternativePicture="microphoneOn"
        :activePicture="microphoneOff"
        :currentDevice="currentAudioInputDevices"
        :devices="audioInputDevices"
        :showDevices="showAudioInputDevices"
        :show="showAudio"
        @mute="handleMuteAudio"
        @showDevices="handleShowDevice"
        @changeDevice="handleChangeDevice"
      />
      <control-element
        deviceKind="audiooutput"
        :activePicture="earphone"
        :currentDevice="currentAudioOutputDevices"
        :devices="audioOutputDevices"
        :showDevices="showAudioOutputDevices"
        @showDevices="handleShowDevice"
        @changeDevice="handleChangeDevice"
      />
      <control-element
        deviceKind="videoinput"
        :alternativePicture="camcorderOn"
        :activePicture="camcorderOff"
        :currentDevice="currentVideoInputDevices"
        :devices="videoInputDevices"
        :showDevices="showVideoInputDevices"
        :show="showVideo"
        @mute="handleMuteVideo"
        @showDevices="handleShowDevice"
        @changeDevice="handleChangeDevice"
      />
      <div
        @click="handleScreenBroadcast"
        class="screen_display  rounded-full w-10 h-10 bg-gray-300 border border-gray-300 flex justify-center
            items-center cursor-pointer shadow-lg hover:bg-gray-500 hover:border-gray-500 dark:bg-rose-800
            dark:hover:ring-rose-900">
        <svg
          class="h-6 w-6 text-gray-700"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
          <line x1="8" y1="21" x2="16" y2="21"/>
          <line x1="12" y1="17" x2="12" y2="21"/>
        </svg>
      </div>
      <div
        @click="handleLeavingMeeting"
        class="leave_meeting rounded-full w-20 h-10 bg-red-700 border border-red-700 flex justify-center
            items-center cursor-pointer shadow-lg hover:bg-red-800 hover:border-red-800 dark:bg-rose-800
            dark:hover:ring-rose-900"
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
          <path d="M10.68 13.31a16 16 0 0 0 3.41 2.6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7 2 2 0 0
              1 1.72 2v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.42 19.42 0 0 1-3.33-2.67m-2.67-3.34a19.79
              19.79 0 0 1-3.07-8.63A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45
              2.11L8.09 9.91"
          />
          <line x1="23" y1="1" x2="1" y2="23"/>
        </svg>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>