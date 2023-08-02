<template>
  <component :is="setLayout">
    <router-view v-model:layout="layout"/>
  </component>
</template>

<script>
import DefaultLayout from "../layouts/DefaultLayout.vue";
import MainLayout from "../layouts/MainLayout.vue";
import LoginLayout from "../layouts/LoginLayout.vue";

const layouts = {
  'MainLayout': MainLayout,
  'DefaultLayout': DefaultLayout,
  'LoginLayout': LoginLayout
}

export default {
  name: "App",
  components: {
    DefaultLayout
  },
  data() {
    return {
      layout: 'DefaultLayout',
      hello1: 'Hello1'
    };
  },
  computed: {
    setLayout() {
      return layouts[this.layout];
    }
  }
}
</script>

<style scoped>

</style>