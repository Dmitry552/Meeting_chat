<template>
  <div
    :class="['relative transition-all ease-in-out duration-200 bg-white cursor-pointer',
    'shadow-[0px_0px_20px_0px_#d1d5db] z-0',
    showChat ? 'w-[300px]' : 'w-0']"
  >
    <div
      @click="handleHidingChat"
      class="absolute transition-all ease-in-out duration-100 top-14 left-6 hover:left-7"
    >
      <svg
        class="w-6 h-6 text-gray-300 dark:text-white hover:text-gray-500"
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
</template>

<script>
export default {
  name: "TextChat",
  props: {
    showChat: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    handleHidingChat() {
      this.$emit('hidingShowChat');
    }
  }
}
</script>

<style scoped>

</style>