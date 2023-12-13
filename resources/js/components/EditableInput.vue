<script setup lang="ts">
import {reactive, ref, toRef, toRefs, watch} from "vue";

type TModelValue = boolean | string | number;

type TProps = {
  editing: boolean,
  title: string,
  modelValue?: TModelValue,
  error?: any,
}

const props = defineProps<TProps>();
const slots = defineSlots();

const changField = ref<boolean>(false);
const oldValue = ref<TModelValue | null>(null);

const emits = defineEmits<{
  (e: 'update:modelValue', value: TModelValue): void
  (e: 'blur'): void
}>();

watch(props.error, (value) => {
  console.log('error', value);
})

const startChanges = () => {
  oldValue.value = props.modelValue;
  changField.value = true;
}

const rejectChanges = () => {
  emits('update:modelValue', oldValue.value as TModelValue);
  oldValue.value = null;
  changField.value = false;
}

</script>

<template>
  <div class="flex">
    <div class="px-4 py-2 font-semibold basis-1/2">{{props.title}}</div>
    <div v-if="!changField" class="px-4 py-2 basis-1/2">{{props.modelValue}}</div>
    <div v-if="!changField && props.editing" class="relative flex justify-center items-center h-full">
      <svg
        @click="startChanges"
        class="h-full w-6 text-gray-400 cursor-pointer absolute top-0 right-0"
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
        <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4" />
        <line x1="13.5" y1="6.5" x2="17.5" y2="10.5" />
      </svg>
    </div>
    <div v-if="props.editing && !slots.default && changField" class="flex">
      <input
        class="border border-gray-300 px-2 py-2 rounded-lg w-auto h-full"
        type="text"
        :value="props.modelValue"
        @input="$emit('update:modelValue', $event.target?.value)"
        @blur="$emit('blur')"
      />
      <div v-if="!changField && props.editing" class="relative flex justify-center items-center h-full">
        <svg
          @click="startChanges"
          class="h-full w-6 text-gray-400 cursor-pointer absolute top-0 right-0"
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
          <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4" />
          <line x1="13.5" y1="6.5" x2="17.5" y2="10.5" />
        </svg>
      </div>
      <div v-if="changField && props.editing" class="relative flex justify-center items-center h-full">
        <svg
          @click="rejectChanges"
          class="h-full w-6 text-gray-400 cursor-pointer absolute top-0 right-0"
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
          <line x1="18" y1="6" x2="6" y2="18" />
          <line x1="6" y1="6" x2="18" y2="18" />
        </svg>
      </div>
    </div>
    <slot
      v-if="props.editing && slots.default"
      :value="props.modelValue"
      @closed="$emit('update:modelValue', $event.target?.value)"
    ></slot>
  </div>
</template>

<style scoped>

</style>