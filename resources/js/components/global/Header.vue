<template>
  <header class="bg-white absolute w-full px-2 dark:bg-gray-600">
    <nav class="mx-auto flex max-w-full items-center justify-between p-3 lg:px-3">
      <div class="flex lg:flex-1">
        <router-link to="/" class="-m-1.5 p-1.5" v-if="showLogo">
          <span class="sr-only">Your Company</span>
          <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="">
        </router-link>
      </div>
      <div class="flex items-center">
        <localization-selection/>
        <theme-selection/>
        <div class="lg:flex lg:flex-1 lg:justify-end" v-if="showLogIn">
          <router-link
            to="/log-in"
            class=" flex items-center text-sm font-semibold leading-6 text-gray-800 dark:text-white dark:hover:text-gray-200"
          >
            {{$t("handler['log in']")}}
            <span aria-hidden="true">
                <svg class="ml-1 w-[15px] h-[15px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.1" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
              </span>
          </router-link>
        </div>
      </div>
    </nav>
  </header>
</template>

<script>
import LocalizationSelection from "../LocalizationSelection.vue";
import ThemeSelection from "../ThemeSelection.vue";
export default {
  name: "Header",
  components: {
    'localization-selection': LocalizationSelection,
    'theme-selection': ThemeSelection
  },
  props: {
    showLogIn: {
      type: Boolean,
      default: true
    },
    showLogo: {
      type: Boolean,
      default: true
    }
  }
}
</script>

<style scoped>

</style>