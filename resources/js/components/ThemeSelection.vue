<script lang="ts" setup>
import {ref, watch} from "vue";
import {setTheme} from "../store/modules/Global/mutations";

const theme = ref<string>('');

function handleThemeSelection(): void {
  theme.value === 'dark' ? theme.value = 'light' : theme.value = 'dark';
}

if (localStorage.theme === 'dark') {
  document.documentElement.classList.add('dark');
  setTheme('dark');
  theme.value = 'light';
} else if ((!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
  document.documentElement.classList.add('dark');
  setTheme('dark');
  localStorage.setItem('theme', 'dark');
  theme.value = 'light';
} else {
  document.documentElement.classList.remove('dark');
  setTheme('light');
  localStorage.setItem('theme', 'light');
  theme.value = 'dark';
}

watch<string>(theme, (value, oldValue) => {
  if (oldValue === 'dark') {
    document.documentElement.classList.add('dark');
    setTheme('dark');
    localStorage.setItem('theme', 'dark');
  } else {
    document.documentElement.classList.remove('dark');
    setTheme('light');
    localStorage.setItem('theme', 'light');
  }
})
</script>

<template>
  <div @click="handleThemeSelection" class="mr-4 cursor-pointer">
    <svg
      v-if="theme === 'dark'"
      class="w-[18px] h-[18px] text-gray-800 dark:text-white"
      aria-hidden="true"
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 18 20"
    >
      <path
        stroke="currentColor"
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="1.2"
        d="M8.509 5.75c0-1.493.394-2.96 1.144-4.25h-.081a8.5 8.5 0 1 0 7.356 12.746A8.5 8.5 0 0 1 8.509 5.75Z"
      />
    </svg>
    <svg
      v-else
      class="w-[18px] h-[18px] text-gray-800 dark:text-white"
      aria-hidden="true"
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 20 20"
    >
      <path
        stroke="currentColor"
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="1.2"
        d="M10 3V1m0 18v-2M5.05 5.05 3.636 3.636m12.728 12.728L14.95 14.95M3 10H1m18 0h-2M5.05 14.95l-1.414
          1.414M16.364 3.636 14.95 5.05M14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"
      />
    </svg>
  </div>
</template>

<style scoped>

</style>