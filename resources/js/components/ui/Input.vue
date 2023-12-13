<script lang="ts" setup>
type TProps = {
  type?: string,
  name?: string,
  value?: string,
  placeholder?: string,
  error?: any,
  modelValue?: string
}

const props = withDefaults(defineProps<TProps>(), {
  type: 'text'
});

const emits = defineEmits<{
  (e: 'update:modelValue', value: Event): void,
  (e: 'blur'): void
}>();

const handleInput = (event: Event) => {
  emits('update:modelValue', event.target.value as HTMLInputElement);
}

const handleBlur = () => {
  emits('blur');
}
</script>

<template>
  <input
    :type="props.type"
    :name="props.name"
    :value="props.modelValue"
    @input="handleInput"
    @blur="handleBlur"
    :placeholder="props.placeholder"
    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
      focus:ring-primary-600 focus:border-primary-600 block w-full px-2 py-1 dark:bg-gray-700
      dark:border-gray-600 mb-5 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
      dark:focus:border-blue-500"
    :class="{['dark:border-red-500 border-red-500']: props.error}"
  >
</template>

<style scoped>

</style>