<script lang="ts" setup>

const props = withDefaults(defineProps<{showClientList: boolean}>(), {showClientList: false});
const emit = defineEmits<{(e: 'hidingClientList'): void}>();

function handleHidingClientList() {
  emit('hidingClientList');
}
</script>

<template>
  <div
    :class="['relative transition-all ease-in-out duration-100 bg-white cursor-pointer flex-none',
      'shadow-[0px_0px_20px_0px_#d1d5db] z-20',
      'dark:bg-gray-600 dark:shadow-gray-700',
      showClientList ? 'w-full md:w-[320px]' : 'w-0']"
  >
    <div
      @click="handleHidingClientList"
      class="absolute transition-all ease-in-out duration-100 top-14 right-6 hover:right-7"
    >
      <svg
        class="w-6 h-6 text-gray-300 dark:text-white hover:text-gray-500 dark:hover:text-gray-500"
        aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 14 10"
      >
        <path
          stroke="currentColor"
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M13 5H1m0 0 4 4M1 5l4-4"
        />
      </svg>
    </div>
  </div>
</template>

<style scoped>

</style>