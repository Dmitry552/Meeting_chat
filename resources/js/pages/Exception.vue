<script async setup lang="ts">
import {useStore} from "../store";
import useSocket from "../composables/useSocket";

const store = useStore();

const getRoom = (data: string) => store.dispatch('getRoom', data);

await getRoom('4f34f271-1faa-4279-a86b-6eeac04164bd');

const {
  listenChannel
} = useSocket();

// listenChannel(
//   `4f34f271-1faa-4279-a86b-6eeac04164bd`
// );

function handleClick() {

}
</script>

<template>
  <h3>Hello</h3>
  <button @click="handleClick">JOIN</button>
</template>

<style scoped>

</style>