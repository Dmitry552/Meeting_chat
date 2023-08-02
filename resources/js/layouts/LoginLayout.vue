<template>
  <div class="w-full h-screen">
    <m-header :showLogo="false" :showLogIn="false"/>
    <main class="bg-white dark:bg-gray-600 h-full px-3.5 flex
          justify-center items-center"
    >
      <slot/>
    </main>
  </div>
</template>

<script>
export default {
  name: "LoginLayout",
}
</script>

<style scoped>

</style>