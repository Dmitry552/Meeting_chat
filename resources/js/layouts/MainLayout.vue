<template>
  <div class="LayoutDefault">
    <nav class="LayoutDefault__nav">
      <router-link to="/">Home</router-link> |
<!--      <router-link to="/about">About</router-link>-->
    </nav>
    <main class="LayoutDefault__main">
      <slot/>
    </main>
    <footer class="LayoutDefault__footer">
    </footer>
  </div>
</template>

<script>
export default {
  name: "LayoutDefault",
}
</script>

<style scoped>

</style>