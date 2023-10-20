<script lang="ts" setup>

const props = withDefaults(defineProps<{showChat: boolean}>(),  {showChat: false});
const emit = defineEmits<{(e: 'hidingShowChat'): void}>();

function handleHidingChat() {
  emit('hidingShowChat');
}
</script>

<template>
  <div
    :class="['hidden md:block relative transition-all ease-in-out duration-200 bg-white cursor-pointer flex-none',
    'shadow-[0px_0px_20px_0px_#d1d5db] z-20',
    'dark:bg-gray-600 dark:shadow-gray-700',
    showChat ? 'w-[300px] lg:w-[400px]' : 'w-0']"
  >
    <div
      @click="handleHidingChat"
      class="absolute transition-all ease-in-out duration-100 top-14 left-6 hover:left-7"
    >
      <svg
        class="w-6 h-6 text-gray-300 dark:text-gray-300 hover:text-gray-500 dark:hover:text-gray-500"
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
          d="M1 5h12m0 0L9 1m4 4L9 9"
        />
      </svg>
    </div>
  </div>
  <div
    :class="['md:hidden absolute top-0 right-0 h-full z-20 shadow-[0px_0px_20px_0px_#d1d5db]',
    ['transition-all ease-in-out duration-200 bg-white dark:bg-gray-600 dark:shadow-gray-700'],
    showChat ? 'w-full' : 'w-0']"
  >
    <div
      :class="['h-full relative']"
    >
      <div
        @click="handleHidingChat"
        class="absolute transition-all ease-in-out duration-100 top-20 left-6 hover:left-7"
      >
        <svg
          class="w-6 h-6 text-gray-300 dark:text-gray-300 hover:text-gray-500 dark:hover:text-gray-500"
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
            d="M1 5h12m0 0L9 1m4 4L9 9"
          />
        </svg>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>