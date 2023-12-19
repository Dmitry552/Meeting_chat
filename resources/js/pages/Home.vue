<script lang="ts" setup>
import {v4} from 'uuid';
import {computed, ref} from "vue";
import {useI18n} from "vue-i18n";
import {useRouter} from "vue-router";
import {useStore} from "../store";
import swal from "sweetalert";
import {errorHandler, isValidUrl} from "../utils/helpers";

type TRoomData = {
  name: string
}

type TInterlocutorData = {
  userName?: string
}

const {push} = useRouter();
const {t} = useI18n();
const store = useStore();

const roomLinks = ref<string>('');

const authUser = computed(() => store.getters.getAuthUser);
const joinRoom = (data: TRoomData) => store.dispatch('joinRoom', data);
const createInterlocutor = (data: TInterlocutorData) => store.dispatch('createInterlocutor', data);

async function handleCreateNewRoom(): void {
  let stop: boolean = false;
  const dataInterlocutor: TInterlocutorData = {};

  if (!authUser.value) {
    const result = await swal( {
      content: "input",
      title: "Ops!",
      text: t("errors.home['missing userName']"),
      icon: "warning",
    })

    if (result) {
      dataInterlocutor.userName = result;
    } else {
      stop = await swal({
        title: "Ops!",
        text: 'Данные необходимо ввести!',
        icon: "warning",
      });
    }
  }

  if (!stop) {
    await createNewRoom(dataInterlocutor);
    //push(`/room/${roomID}`);
  }
}

function handleEnterAnRoom(): void {
  isValidUrl(roomLinks.value)
  if (true) {
    if (roomLinks.value.startsWith(`${import.meta.env.VITE_APP_URL}/room/`)) {
      const url = new URL(roomLinks.value);

      console.log(url.pathname);
      //push(url.pathname);
    } else {
      swal( {
        title: "Ops!",
        text: t("errors.home.url"),
        icon: "warning",
      });
    }
  } else {
    console.log('ffff');
    //push(`/room/${roomLinks.value}`);
  }
}

async function createNewRoom(data): void {
  const roomID = v4();
  try {
    await createInterlocutor(data);
    await joinRoom({name: roomID})
  } catch (err) {
    errorHandler(err.response)
  }
}
</script>

<template>
  <div class="w-2/3 relative">
    <button
      class="text-white bg-blue-700 border border-blue-700 rounded-md text-sm mx-auto w-1/2 h-10 block
          hover:bg-blue-800 shadow-lg font-semibold dark:bg-blue-950 dark:border-blue-950 dark:hover:bg-blue-900
          dark:hover:border-blue-900 dark:text-gray-300 lg:w-1/3 xl:w-1/4"
      @click="handleCreateNewRoom"
    >
      {{$t("home['create new room']")}}
    </button>
    <h1 class="text-center my-1 dark:text-gray-300">
      {{$t("home['or']")}}
    </h1>
    <div class="lg:flex items-center lg:h-10">
      <div class="relative lg:w-full lg:h-full">
        <div class="absolute flex items-center h-full left-4">
          <svg
            class="w-[20px] h-[20px] text-gray-800 dark:text-white"
            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            width="20" height="14"
            fill="none"
            viewBox="0 0 20 14"
          >
            <path
              stroke="currentColor"
              stroke-width="1.2"
              d="M1 2a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2Z"
            />
            <path
              stroke="currentColor"
              stroke-width="1.2"
              d="M4 4h.01v.01H4V4Zm3 0h.01v.01H7V4Zm3 0h.01v.01H10V4Zm3 0h.01v.01H13V4Zm3 0h.01v.01H16V4Zm0
                3h.01v.01H16V7Zm-3 0h.01v.01H13V7Zm-3 0h.01v.01H10V7ZM7 7h.01v.01H7V7ZM4 7h.01v.01H4V7Zm0
                3h.01v.01H4V10Zm12 0h.01v.01H16V10ZM6 10h7.01v.01H13L6 10Z"
            />
          </svg>
        </div>
        <input
          type="text"
          id="small-input"
          :placeholder="$t('home[\'id room\']')"
          v-model="roomLinks"
          class="pl-10 block w-full text-gray-900 border border-gray-500 rounded-md shadow-lg cursor-text
            focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-700 dark:placeholder-gray-400
            dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder-gray-500
            dark:border-r-gray-300 lg:rounded-r-none lg:h-full"
        >
      </div>
      <button
        class="block leading-3 w-1/2 lg:w-1/3 p-2 text-gray-700 bg-white border border-gray-300 rounded-md
          text-sm mx-auto font-semibold h-10 hover:bg-gray-100 shadow-lg mt-3 dark:bg-gray-700 dark:border-gray-700
          dark:text-gray-300 dark:hover:bg-gray-800 xl:w-1/4 lg:rounded-l-none lg:border-l-0 lg:mx-0 lg:mt-0 lg:h-full"
        @click="handleEnterAnRoom"
      >
        {{$t("home['enter']")}}
      </button>
    </div>
  </div>
</template>

<style scoped>

</style>