<template>
  <div>
    <label v-if="showLabel" for="password" class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">
      <slot/>
    </label>
    <div class="relative">
      <input
        :type="type"
        name="password"
        id="password"
        :value="modelValue"
        @input="handleInput"
        :placeholder="placeholder"
        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
      focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700
      dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
      dark:focus:border-blue-500"
      >
      <div @click="handleShowPassword" class="absolute top-0 right-0 h-full flex items-center mr-2 cursor-pointer">
        <svg v-if="showPassword" class="h-[20px] w-[20px] text-black dark:text-white"  viewBox="0 0 24 24"  fill="none"
             stroke="currentColor"  stroke-width="1.1" stroke-linecap="round"  stroke-linejoin="round">
          <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0
              1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" />
          <line x1="1" y1="1" x2="23" y2="23" />
        </svg>
        <svg v-else class="h-[20px] w-[20px] text-black dark:text-white"  viewBox="0 0 24 24"  fill="none" stroke="currentColor"
             stroke-width="1.1" stroke-linecap="round"  stroke-linejoin="round">
          <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />  <circle cx="12" cy="12" r="3" />
        </svg>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "InputPassword",
  props: {
    showLabel: {
      type: Boolean,
      default: true
    },
    placeholder: {
      type: String,
      default: '••••••••'
    },
    modelValue: {
      type: [String, Number],
      default: ''
    },
  },
  data() {
    return {
      showPassword: false,
      type: 'password'
    }
  },
  methods: {
    handleInput(event) {
      this.$emit('update:modelValue', event.target.value)
    },
    handleShowPassword() {
      this.showPassword = !this.showPassword;
    }
  },
  watch: {
    showPassword() {
      this.type === 'password' ? this.type = 'text' : this.type = 'password'
    }
  }
}
</script>

<style scoped>

</style>