<script setup lang="ts">
import {useStore} from "../../store";
import {computed} from "vue";
import {Message as TMessage} from "../../types";
import Message from "./Message.vue";
import {useI18n} from "vue-i18n";

type TPropsMessageList = {
  clientName: string | null
}

const store = useStore();
const {t} = useI18n();

const props = defineProps<TPropsMessageList>();

const messages = computed<TMessage[]>(() => store.getters.getMessages);
const clientEventMessage = computed(() => t("textChat.typing", {name: props.clientName}))
</script>

<template>
  <div
    class="overflow-y-scroll h-full w-full mb-2 shadow-lg border border-gray-300 bg-white dark:bg-gray-500
      dark:border-gray-500 rounded-lg flex flex-col justify-end p-3 gap-2 relative pb-6"
  >
    <message
      v-for="message in messages"
      :key="message.id"
      :content="message"
    />
    <div v-if="clientName" class="absolute bottom-0 right-2 w-full h-6 mb-0 text-gray-50 text-right text-sm">
      {{clientEventMessage}}
    </div>
  </div>
</template>

<style scoped>

</style>