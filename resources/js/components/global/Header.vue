<script lang="ts" setup>
import LocalizationSelection from "../LocalizationSelection.vue";
import ThemeSelection from "../ThemeSelection.vue";

type THeaderProps = {
  showLogIn?: boolean,
  showLogo?: boolean
}

const props = withDefaults(defineProps<THeaderProps>(), {showLogIn: true, showLogo: true})
</script>

<template>
  <header class="bg-white absolute w-full px-2 dark:bg-gray-600 z-50">
    <nav class="mx-auto flex max-w-full items-center justify-between p-2 lg:px-3">
      <div class="flex lg:flex-1">
        <router-link to="/" class="-m-1.5 p-1.5" v-if="showLogo">
          <span class="sr-only">Your Company</span>
          <svg class="h-6 w-auto" viewBox="0 0 174 104" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M17 104L17 76L43 76L17 104Z" fill="#1D4ED8"/>
            <path d="M120.64 41.6156C117.588 40.1713 117.588 35.8287 120.64 34.3844L153.039 19.052C155.693 17.7962
                  158.75 19.7318 158.75 22.6676L158.75 53.3324C158.75 56.2682 155.693 58.2038 153.039 56.948L120.64
                  41.6156Z" fill="#1D4ED8"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M8 0C3.58173 0 0 3.58173 0 8V68C0 72.4183 3.58173 76 8
                  76H118C122.418 76 126 72.4183 126 68V8C126 3.58173 122.418 0 118 0H8ZM17 13C14.2386 13 12 15.2386 12
                  18V58C12 60.7614 14.2386 63 17 63H108C110.761 63 113 60.7614 113 58V18C113 15.2386 110.761 13 108
                  13H17Z" fill="#1D4ED8"/>
          </svg>
        </router-link>
      </div>
      <div class="flex items-center">
        <localization-selection/>
        <theme-selection/>
        <div class="lg:flex lg:flex-1 lg:justify-end" v-if="showLogIn">
          <router-link
            to="/sign-in"
            class="flex items-center text-sm font-semibold leading-6 text-gray-800 dark:text-white
              dark:hover:text-gray-200"
          >
            {{$t("handler['log in']")}}
            <span aria-hidden="true">
                <svg
                  class="ml-1 w-[15px] h-[15px] text-gray-800 dark:text-white"
                  aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 14 10"
                >
                  <path
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.1" d="M1 5h12m0 0L9 1m4 4L9 9"
                  />
                </svg>
              </span>
          </router-link>
        </div>
      </div>
    </nav>
  </header>
</template>

<style scoped>

</style>