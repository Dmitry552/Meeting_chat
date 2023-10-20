<script setup lang="ts">
import {computed} from "vue";

type TControlElement = {
  show?: boolean,
  alternativePicture?: string
  activePicture: string
  deviceKind: string
  showDevices: boolean,
  devices: MediaDeviceInfo[],
  currentDevice: MediaDeviceInfo
}

const props = defineProps<TControlElement>();

const emits = defineEmits<{
  (e: 'mute'): void,
  (e: 'showDevices', value: string): void,
  (e: 'changeDevice', value: HTMLInputElement): void,
}>()

function handleMute() {
  emits('mute');
}

function handleShowDevices() {
  emits('showDevices', props.deviceKind)
}

function handleChangeDevice(event: Event) {
  console.log(event);
  emits(
    'changeDevice',
    event.target as HTMLInputElement
  )
}

const listTopPosition = computed(() => {
  return 'top: -' + (20+(props.devices.length * 55)) + 'px';
})

const listLeftPosition = computed<string>(() => {
  switch (props.deviceKind) {
    case 'audioinput':
      return 'left-0'
    default:
      return '-left-32'
  }
});
</script>

<template>
  <div class="relative h-10 flex justify-center items-center rounded-full shadow-lg">
    <div
      v-if="deviceKind === 'audiooutput'"
      @click="handleShowDevices"
      class="px-2 h-full shadow-lg rounded-full bg-gray-300 border border-gray-300 flex justify-center
            items-center gap-2 cursor-pointer hover:bg-gray-500 hover:border-gray-500 dark:bg-rose-800
            dark:hover:ring-rose-900"
    >
      <img v-if="show || !alternativePicture" class="h-6 w-6 text-gray-700" :src="activePicture" alt="icon">
      <svg class="h-6 w-6 text-gray-700"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
      </svg>
    </div>
    <div
      v-else
      @click="handleMute"
      class="h-full w-10 rounded-l-full bg-gray-300 border border-gray-300 flex justify-center
            items-center cursor-pointer hover:bg-gray-500 hover:border-gray-500 dark:bg-rose-800
            dark:hover:ring-rose-900"
    >
      <img v-if="show || !alternativePicture" class="h-6 w-6 text-gray-700" :src="activePicture" alt="icon">
      <img v-if="!show && alternativePicture" class="h-6 w-6 text-gray-700" :src="alternativePicture" alt="icon">
    </div>
    <button
      v-if="deviceKind !== 'audiooutput'"
      @click="handleShowDevices"
      class="w-10 h-full rounded-r-full bg-gray-300 border border-gray-300 flex justify-center
          items-center cursor-pointer hover:bg-gray-500 hover:border-gray-500 dark:bg-rose-800
          dark:hover:ring-rose-900"
    >
      <svg class="h-6 w-6 text-gray-700"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
      </svg>
    </button>
    <div
      v-show="showDevices"
      :class="['absolute', listLeftPosition,
            'bg-white divide-y divide-gray-100 rounded-lg shadow',
            'dark:bg-gray-700']"
      :style="[listTopPosition]"
    >
      <ul
        @change="handleChangeDevice"
        class="py-1 text-sm text-gray-700 dark:text-gray-200"
      >
        <li
          class="w-80 h-[55px] px-4 py-1 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white
                cursor-pointer flex gap-2"
          v-for="(device, index) in devices"
        >
          <input
            class="cursor-pointer"
            type="radio"
            :checked="device.deviceId === props.currentDevice.deviceId"
            :name="deviceKind"
            :value="device.deviceId"
            :id="deviceKind + '-' + index"
          />
          <label class="cursor-pointer" :for="deviceKind + '-' + index">{{device.label}}</label>
        </li>
      </ul>
    </div>
  </div>
</template>

<style scoped>

</style>