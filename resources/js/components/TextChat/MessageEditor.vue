<script setup lang="ts">
import {computed, ref} from 'vue';
import {MdEditor, NormalToolbar} from "md-editor-v3";
import 'md-editor-v3/lib/style.css';
import {useStore} from "../../store";

const store = useStore();

const text = ref<string>('');

const emits = defineEmits<{
  (e: 'sendMessage', value: string): void
  (e: 'typingMessage'): void
  (e: 'noTypingMessage'): void
}>();

const theme = computed(() => store.getters.getTheme);

function handlerSendMessage() {
  console.log(text.value);
  emits('sendMessage', text.value);
  text.value = '';
}

function handlerTypingMessage() {
  emits('typingMessage');
}

function handlerNoTypingMessage() {
  emits('noTypingMessage');
}
</script>

<template>
  <div
    class="w-full h-full"
  >
    <MdEditor
      @focusin="handlerTypingMessage"
      @focusout="handlerNoTypingMessage"
      v-model="text"
      style="height: 100%; border-radius: 10px"
      :preview="false"
      :toolbars="['bold', 'underline', 'italic', '=', 0]"
      :footers="[]"
      :theme="theme"
    >
      <template #defToolbars>
        <NormalToolbar @onClick="handlerSendMessage">
          <template #trigger>
            <svg
              class="h-6 w-6 text-gray-500"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              stroke-width="2"
              stroke="currentColor"
              fill="none"
              stroke-linecap="round"
              stroke-linejoin="round"
            >
              <path stroke="none" d="M0 0h24v24H0z"/>
              <path d="M21 3L14.5 21a.55 .55 0 0 1 -1 0L10 14L3 10.5a.55 .55 0 0 1 0 -1L21 3" />
            </svg>
          </template>
        </NormalToolbar>
      </template>
    </MdEditor>
  </div>
</template>

<style scoped>

</style>