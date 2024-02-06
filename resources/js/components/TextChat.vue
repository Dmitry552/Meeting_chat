<script lang="ts" setup>
import MessagesList from "./TextChat/MessagesList.vue";
import MessageEditor from "./TextChat/MessageEditor.vue";
import useTextChat from "../composables/useTextChat";
import {computed, ref, watch} from "vue";
import {useStore} from "../store";
import {Interlocutor} from "../types";
import Splitter from 'primevue/splitter';
import SplitterPanel from 'primevue/splitterpanel';

const store = useStore();

const {
  clientName,
  textChannel,
  handleSendMessage
} = useTextChat();

const typing = ref<boolean>(false);

const props = withDefaults(defineProps<{showChat: boolean}>(),  {showChat: false});
const emit = defineEmits<{(e: 'hidingShowChat'): void}>();

const currentInterlocutor = computed<Interlocutor>(() => store.getters.getCurrentInterlocutor);
const getMessages = () => store.dispatch('getMessages');

getMessages();

function typingMessage() {
  typing.value = true;
}

function noTypingMessage() {
  typing.value = false;
}

watch(typing, () => {
  if (typing.value) {
    textChannel.value.whisper('typing', {
      interlocutor: currentInterlocutor.value.code
    });
  } else {
    textChannel.value.whisper('noTyping', {
      interlocutor: currentInterlocutor.value.code
    });
  }
})

function handleHidingChat() {
  emit('hidingShowChat');
}
</script>

<template>
  <div
    :class="[
      'absolute w-full h-full top-0 left-0 transition-all ease-in-out duration-500 bg-white flex-none p-3',
      'shadow-[0px_0px_20px_0px_#d1d5db] z-20',
      'dark:bg-gray-600 dark:shadow-gray-700',
      showChat
        ? 'translate-x-[0px]'
        : 'translate-x-[3000px]',
    ]"
  >
    <div
      @click="handleHidingChat"
      class="absolute transition-all ease-in-out duration-100 top-14 left-6 hover:left-7 cursor-pointer"
    >
      <svg
        class="w-6 h-6 text-gray-300 dark:text-gray-300 hover:text-gray-500 dark:hover:text-gray-500"
        aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 14 10"
      >
        <path
          stroke="currentColor"
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M1 5h12m0 0L9 1m4 4L9 9"
        />
      </svg>
    </div>
    <div
      class="pt-20 w-full h-full"
    >
      <Splitter style="height: 100%; border-radius: 10px" layout="vertical">
        <SplitterPanel :size="75" :minSize="20">
          <messages-list :clientName="clientName"/>
        </SplitterPanel>
        <SplitterPanel :size="25" :minSize="20">
          <message-editor
            @sendMessage="handleSendMessage"
            @typingMessage="typingMessage"
            @noTypingMessage="noTypingMessage"
          />
        </SplitterPanel>
      </Splitter>
    </div>
  </div>
</template>

<style scoped>

</style>