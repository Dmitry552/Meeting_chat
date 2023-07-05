<template>
Hello
</template>

<script>
import DefaultLayout from '../layouts/DefaultLayout.vue';

export default {
  name: "Home",
  created() {
    this.$emit('update:layout', DefaultLayout)
  }
}
</script>

<style scoped>

</style>