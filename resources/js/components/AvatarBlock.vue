<script setup lang="ts">
import {useStore} from "../store";
import {computed, ref} from "vue";
import {User} from "../types";
import {useRouter} from "vue-router";

const showDropdownMenu = ref<boolean>(false);

const store = useStore();
const {push} = useRouter();

const authUser = computed<User | null>(() => store.getters.getAuthUser);
const logout = () => store.dispatch('logout');

const handleDropdownMenu = () => {
  showDropdownMenu.value = !showDropdownMenu.value;
}

const handleButtonHome = () => {
  push('/');
}

const handleSettingButton = () => {
  push(`/user/${authUser.value?.id}`)
}

const handleSignOut = () => {
  logout().then(() => {
    push('/');
  })
}
</script>

<template>
  <div class="relative">
    <img
      id="avatarButton"
      @click="handleDropdownMenu"
      v-if="authUser?.avatarPath"
      type="button"
      class="w-10 h-10 rounded-full cursor-pointer"
      :src="authUser?.avatarPath"
      alt="User dropdown"
    >
    <div
      v-else
      @click="handleDropdownMenu"
      class="relative w-10 h-10 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600 cursor-pointer"
    >
      <svg
        class="absolute w-8 h-8 text-gray-400 -left-1"
        fill="currentColor"
        viewBox="0 0 20 20"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          fill-rule="evenodd"
          d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
          clip-rule="evenodd"
        ></path>
      </svg>
    </div>

    <!-- Dropdown menu -->
    <div
      v-show="showDropdownMenu"
      class="absolute top-12 -left-32 z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600"
    >
      <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
        <div>{{authUser?.lastName}} {{authUser?.firstName}}</div>
        <div class="font-medium truncate">{{authUser?.email}}</div>
      </div>
      <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="avatarButton">
        <li>
          <button
            @click="handleButtonHome"
            class="block w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-left"
          >
            Home
          </button>
        </li>
        <li>
          <button
            @click="handleSettingButton"
            class="block w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-left"
          >
            Settings
          </button>
        </li>
      </ul>
      <div class="py-1">
        <button
          @click="handleSignOut"
          class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200
          dark:hover:text-white w-full text-center"
        >
          Sign out
        </button>
      </div>
    </div>
  </div>

</template>

<style scoped>

</style>