<template>
  <div class="w-full h-screen">
    <m-header/>
    <main class="bg-white dark:bg-gray-600 h-full px-2 flex
          justify-center items-center"
    >
      <slot/>
    </main>
  </div>
</template>

<script>
export default {
  name: "MainLayout",
}
</script>

<style scoped>

</style>