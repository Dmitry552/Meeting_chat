<script lang="ts" setup>
import en from '../../images/en.svg';
import ru from '../../images/ru.svg';
import ua from '../../images/ua.svg';
import {ref} from "vue";
import {useI18n} from "vue-i18n";

const {locale} = useI18n();

const langs = ref<string[]>(['ru', 'en', 'ua']);
const show = ref<boolean>(false);

function flag(lang: string): string {
  switch (lang) {
    case 'ru':
      return ru;
    case 'en':
      return en;
    case 'ua':
      return ua;
    default:
      return '';
  }
}

function handleShow(): void {
  show.value = !show.value;
}

function handleSelected(event: Event): void {
  locale.value = (event.target as HTMLUListElement).id;
  document.documentElement.lang = (event.target as HTMLUListElement).id;
  show.value = false;
}
</script>

<template>
  <div @click="handleShow" class="mr-4 cursor-pointer">
    <div class="relative flex items-center">
      <img class="h-4 mr-1" :src="flag($i18n.locale)" alt="lang">
      <svg
        class="h-[26px] w-[26px] text-black dark:text-white"
        width="24"
        height="24"
        viewBox="0 0 24 24"
        stroke-width="1.1"
        stroke="currentColor"
        fill="none"
        stroke-linecap="round"
        stroke-linejoin="round"
      >
        <path stroke="none" d="M0 0h24v24H0z"/>
        <path d="M5 7h7m-2 -2v2a5 8 0 0 1 -5 8m1 -4a7 4 0 0 0 6.7 4" />
        <path d="M11 19l4 -9l4 9m-.9 -2h-6.2" />
      </svg>
    </div>

    <ul
        v-if="show"
        class="absolute top-15 w-35 p-2 border border-gray-300 dark:border-b-gray-500 rounded-md
        transition ease-in-out h-25"
        @click.stop="handleSelected"
    >
      <li
          v-for="(lang, i) in langs" :key="`Lang${i}`"
          class="flex hover:bg-gray-300 h-8 items-center content-between
          w-full p-1 rounded-sm"
          :id="lang"
      >
        <img class="h-full" :src="flag(lang)" :alt="lang" :id="lang">
      </li>
    </ul>
  </div>
</template>

<style scoped>

</style>