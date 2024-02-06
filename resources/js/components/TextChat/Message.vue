<script setup lang="ts">
import {Interlocutor, Message} from "../../types";
import {computed} from "vue";
import {useStore} from "../../store";

type TMessageProps = {
  content: Message
}

const store = useStore()

const props = defineProps<TMessageProps>();

const currentInterlocutor = computed<Interlocutor>(() => store.getters.getCurrentInterlocutor);

const _html = computed(() => {
 return window.converter.makeHtml(props.content.content);
})
</script>

<template>
  <div :class="['relative w-full grid justify-items-start']">
    <div
      :class="['p-2 rounded-lg shadow-lg m-0 max-w-[300px] overflow-hidden',
      props.content.interlocutor?.id === currentInterlocutor?.id
        ? 'dark:bg-green-300 bg-green-100 justify-self-end'
        : 'bg-gray-100 dark:bg-gray-300 ',
      ]"
      v-html="_html"
    ></div>
  </div>
</template>

<style scoped>

</style>