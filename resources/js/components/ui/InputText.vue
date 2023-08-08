<template>
  <label
    v-if="title"
    :for="name"
    :class="{['after:content-[\'*\'] after:ml-0.5 after:text-red-500']: required}"
    class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-400"
  >
    {{ title }}
  </label>
  <div :class="{'relative': type === 'password'}">
    <input
      :type="currentType"
      v-model="value"
      :id="name"
      :placeholder="placeholder"
      class="bg-gray-50 border border-gray-300 text-gray-900
        sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700
        dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
      :class="{['dark:border-red-500 border-red-500']: errorMessage}"
    />
    <div
      v-if="type === 'password'"
      @click="handleShowPassword"
      class="absolute top-0 right-0 h-full flex items-center mr-2 cursor-pointer"
    >
      <svg
        v-if="showPassword"
        class="h-[20px] w-[20px] text-black dark:text-white"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="1.1"
        stroke-linecap="round"
        stroke-linejoin="round"
      >
        <path
          d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0
              1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"
        />
        <line x1="1" y1="1" x2="23" y2="23" />
      </svg>
      <svg
        v-else
        class="h-[20px] w-[20px] text-black dark:text-white"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="1.1"
        stroke-linecap="round"
        stroke-linejoin="round"
      >
        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />  <circle cx="12" cy="12" r="3" />
      </svg>
    </div>
  </div>
  <span v-if="errorMessage" class="text-sm text-red-500">{{errorMessage}}</span>
</template>

<script>
import {useField} from "vee-validate";

export default {
  name: "InputText",
  setup(props) {
    const { value, errorMessage, setValue } = useField(() => props.name);

    if (props.type === 'checkbox') {
      setValue(false);
    }

    return {
      value,
      errorMessage
    }
  },
  props: {
    title: {
      type: String,
      default: ''
    },
    type: {
      type: String,
      default: 'text'
    },
    name: {
      type: String,
      required: true
    },
    placeholder: {
      type: String,
      default: ''
    },
    required: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      showPassword: false,
      currentType: this.type
    }
  },
  methods: {
    handleShowPassword() {
      this.showPassword = !this.showPassword;
    }
  },
  watch: {
    showPassword() {
      this.currentType === 'password' ? this.currentType = 'text' : this.currentType = 'password'
    }
  }
}
</script>

<style scoped>

</style>