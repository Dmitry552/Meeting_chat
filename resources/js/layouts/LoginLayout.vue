<template>
  <div class="w-full h-screen">
    <m-header :showLogIn="!authUser" :showAvatar="!!authUser"/>
    <main class="bg-white dark:bg-gray-600 h-full px-2 flex
          justify-center items-center overflow-hidden"
    >
      <slot/>
    </main>
  </div>
</template>

<script lang="ts" setup>
import {useStore} from "../store";
import {computed} from "vue";

const store = useStore();
const authUser = computed(() => store.getters.getAuthUser);
</script>

<style scoped>

</style>