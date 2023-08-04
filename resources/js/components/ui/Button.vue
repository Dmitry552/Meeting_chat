<template>
  <button
      class="w-full px-5 py-2.5 text-center text-white bg-blue-700 border border-blue-700 rounded-md
      text-sm mx-auto block hover:bg-blue-800 shadow-lg font-semibold dark:bg-blue-950
      dark:border-blue-950 dark:hover:bg-blue-900 dark:hover:border-blue-900 dark:text-gray-300"
  >
    <slot/>
  </button>
</template>

<script>
export default {
  name: "MyButton",
  props: {

  },
  data() {
    return {

    }
  },
}
</script>

<style scoped>

</style>