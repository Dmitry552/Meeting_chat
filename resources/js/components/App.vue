<template>
  <component :is="layout">
    <router-view v-model:layout="layout"/>
  </component>
</template>

<script>
export default {
  name: "App",
  data() {
    return {
      layout: 'div',
      hello1: 'Hello1'
    };
  }
}
</script>

<style scoped>

</style>