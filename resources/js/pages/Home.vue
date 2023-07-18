<template>
Hello
</template>

<script>
import AddLayoutMixin from "../mixins/AddLayoutMixin";

export default {
  name: "Home",
  mixins: [AddLayoutMixin],
  data() {
    return {
      layoutName: 'main'
    }
  },
}
</script>

<style scoped>

</style>