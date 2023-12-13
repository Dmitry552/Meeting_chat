<script setup lang="ts">
import {useStore} from "../store";
import {useRoute} from "vue-router";
import {computed, ref, watch} from "vue";
import {User} from "../types";
import {errorHandler} from "../utils/helpers";
import UserProfileInfo from "../components/User/UserProfileInfo.vue";
import UserUpdateForm from "../components/User/UserUpdateForm.vue";
import UserUpdatePassword from "../components/User/UserUpdatePassword.vue";
import ProfileCard from "../components/User/ProfileCard.vue";


const {params} = useRoute();
const store = useStore();

const currentUser = ref<boolean>(false);
const showProfile = ref<boolean>(true);
const editingProfile = ref<boolean>(false);
const editingPassword = ref<boolean>(false);

const getUser = (data: string) => store.dispatch('getUser', data);
const authUser = computed<User | null>(() => store.getters.getAuthUser);
const user = computed(() => store.getters.getUser);

getUser((params.id as string))
  .then(data => {
    data.id === authUser.value?.id ? currentUser.value = true : currentUser.value = false;
  }).catch(err => {
  errorHandler(err);
});

const handleEditing = () => {
  showProfile.value = !showProfile.value;
  editingProfile.value = !editingProfile.value;
}

const handleEditingPassword = () => {
  showProfile.value = !showProfile.value;
  editingPassword.value = !editingPassword.value;
}

const handleClose = () => {
  showProfile.value = true;
  editingProfile.value = false;
  editingPassword.value = false;
}
</script>

<template>
  <section class="container m-auto flex justify-center">
    <div class="w-full h-full max-w-6xl m-auto md:flex no-wrap md:-mx-2">
      <!-- Left Side -->
      <div class="w-full md:w-3/12 md:mx-2">
        <profile-card :currentUser="currentUser"/>
        <div class="my-4"></div>
      </div>
      <!-- Right Side -->
      <div class="w-full md:w-9/12 mx-2=">
        <!-- About Section -->
        <div class="bg-white p-3 shadow-sm rounded-sm">
          <div class="flex items-center space-x-2 font-semibold text-gray-900 leading-8">
            <span class="text-green-500">
              <svg class="h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                   stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
            </span>
            <span class="tracking-wide">About</span>
          </div>
          <user-profile-info v-if="showProfile"/>
          <user-update-form v-if="editingProfile" @close="handleClose"/>
          <user-update-password v-if="editingPassword" @close="handleClose"/>
        </div>
        <div class="my-4"></div>
        <div class="flex gap-2 justify-center" v-if="currentUser">
          <ui-button @click="handleEditing" v-if="showProfile && user">Edit profile</ui-button>
          <ui-button @click="handleEditingPassword" v-if="showProfile && user">Change password</ui-button>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>

</style>