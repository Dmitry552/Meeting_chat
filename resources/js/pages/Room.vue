<script lang="ts" setup>
import ClientList from "../components/ClientList.vue";
import TextChat from "../components/TextChat.vue";
import VideoChat from "../components/VideoChat.vue";
import {computed, ref} from "vue";
import {useStore} from "../store";
import {useRoute, useRouter} from "vue-router";
import {Interlocutor, Room, User} from "../types";
import {useI18n} from "vue-i18n";
import useRoomValidation from "../composables/useRoomValidation";
import {errorHandler} from "../utils/helpers";

type TInterlocutorData = {
  userName?: string
}

const store = useStore();
const {params} = useRoute();
const {push} = useRouter();
const {t} = useI18n();
const {checkUserName} = useRoomValidation();

const checkRoom = (data: string) => store.dispatch('checkRoom', data);
const getRoom = (data: string) => store.dispatch('getRoom', data);
const getInterlocutorsRoom = (data: string) => store.dispatch('getInterlocutorsRoom', data);
const createInterlocutor = (data: TInterlocutorData) => store.dispatch('createInterlocutor', data);
const joinRoom = (data) => store.dispatch('joinRoom', data);

const showClientList = ref<boolean>(false);
const showChat = ref<boolean>(false);

const room = computed<Room>(() => store.getters.getRoom);
const currentInterlocutor = computed<Interlocutor>(() => store.getters.getCurrentInterlocutor);
const authUser = computed<User>(() => store.getters.getAuthUser);

checkRoom(params.id as string).then(data => {
  if (!data) {
    push('/');
  }
})

if (!currentInterlocutor.value) {
  const {userName, stopIndicator} = await checkUserName(authUser.value);

  const dataInterlocutor = userName ? {userName} : {};
  const joinData = {
    roomId: params.id,
  }

  if (!stopIndicator) {
    try {
      await createInterlocutor(dataInterlocutor);
      joinData.interlocutor = currentInterlocutor.value.id;
      await joinRoom(joinData);
    } catch (err) {
      errorHandler(err.response)
    }
  } else {
    push('/');
  }
}

getRoom(params.id as string).then(() => {
  getInterlocutorsRoom(room.value.name)
})

function handleShowClientList(): void {
  showClientList.value = !showClientList.value;
}

function handleShowChat() {
  showChat.value = !showChat.value;
}
</script>

<template>
  <div
    class="flex w-full h-full justify-between relative"
  >
    <client-list :showClientList="showClientList" @hidingClientList="handleShowClientList"/>
    <video-chat/>
    <text-chat :showChat="showChat" @hidingShowChat="handleShowChat"/>
    <div class="absolute left-0 top-3/4 h-full">
      <div
        @click="handleShowClientList"
        :class="['transition-all ease-in-out duration-300 relative h-14 w-32 bg-white rounded-r-full cursor-pointer',
            'flex items-center shadow-md shadow-gray-300 hover:bg-gray-300',
            'dark:bg-gray-600 dark:hover:bg-gray-700 dark:shadow-gray-700',
            showClientList ? '-translate-x-36' : '-translate-x-20 hover:-translate-x-16']"
      >
        <svg
          class="absolute w-6 h-full text-gray-500 dark:text-gray-300 right-4"
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 17 14"
        >
          <path
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M1 1h15M1 7h15M1 13h15"
          />
        </svg>
      </div>
    </div>
    <div class="absolute right-0 top-3/4 h-full">
      <div
        @click="handleShowChat"
        :class="['transition-all ease-in-out duration-300 relative h-14 w-32 bg-white rounded-l-full cursor-pointer',
          'flex items-center shadow-md shadow-gray-300 hover:bg-gray-300',
          'dark:bg-gray-600 dark:hover:bg-gray-700 dark:shadow-gray-700',
          showChat ? 'translate-x-36' : 'translate-x-20 hover:translate-x-16']"
      >
        <svg
          class="absolute w-6 h-full text-gray-500 dark:text-white left-4"
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg"
          width="16"
          height="12"
          fill="none"
          viewBox="0 0 16 12"
        >
          <path
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M1 1h14M1 6h14M1 11h7"
          />
        </svg>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>