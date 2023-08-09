<template>
  <div
    :class="['relative transition-all ease-in-out duration-200 bg-white cursor-pointer',
      'shadow-[0px_0px_20px_0px_#d1d5db] w-[300px] z-0',
      showClientList ? '-translate-x-2' : '-translate-x-[102%]']"
  >
    <div class="absolute top-o left-0 flex items-center h-full">
      <div
        @click="handleShowClientList"
        :class="['transition-all ease-in-out duration-300 relative h-14 w-32 bg-white rounded-r-full cursor-pointer',
            'flex items-center shadow-md shadow-gray-300 hover:bg-gray-300',
            showClientList ? '-translate-x-36' : 'translate-x-[220px] hover:translate-x-[230px]']"
      >
        <svg
          class="absolute w-6 h-full text-gray-500 dark:text-white right-4"
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 17 14"
        >
          <path
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M1 1h15M1 7h15M1 13h15"
          />
        </svg>
      </div>
    </div>
    <div
      @click="handleShowClientList"
      class="absolute transition-all ease-in-out duration-100 top-14 right-6 hover:right-7"
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
          d="M13 5H1m0 0 4 4M1 5l4-4"
        />
      </svg>
    </div>
  </div>
</template>

<script>
export default {
  name: "ClientList",
  data() {
    return {
      showClientList: false
    }
  },
  methods: {
    handleShowClientList() {
      this.showClientList = !this.showClientList;
    }
  },
}
</script>

<style scoped>

</style>