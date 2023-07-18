<template>
  <main class="default__main">
    <h1 class="default__warning">
      Вы забыли установить "layoutName" на страницу!!
    </h1>
    <slot/>
  </main>
</template>

<script>
export default {
  name: "MailLayout",
}
</script>

<style scoped>
.default__warning {
  color: #c74646;
}
</style>