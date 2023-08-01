<template>
  <div class="w-full h-screen">
    <header class="bg-white absolute w-full px-2 dark:bg-gray-600">
      <nav class="mx-auto flex max-w-full items-center justify-between p-3 lg:px-3">
        <div class="flex lg:flex-1">
          <router-link to="/" class="-m-1.5 p-1.5">
            <span class="sr-only">Your Company</span>
            <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="">
          </router-link>
        </div>
        <div class="flex items-center">
          <location-selection/>
          <theme-selection/>
          <div class="lg:flex lg:flex-1 lg:justify-end">
            <router-link
                to="#"
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
    <main class="bg-white dark:bg-gray-600 h-full px-3.5 flex
          justify-center items-center"
    >
      <slot/>
    </main>
    <footer class="LayoutDefault__footer">
    </footer>
  </div>
</template>

<script>
import ThemeSelection from "../components/ThemeSelection.vue";
import LocationSelection from "@/components/LocationSelection.vue";
export default {
  name: "LayoutDefault",
  components: {
    'theme-selection': ThemeSelection,
    'location-selection': LocationSelection
  }
}
</script>

<style scoped>

</style>