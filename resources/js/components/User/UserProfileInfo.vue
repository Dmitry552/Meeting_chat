<script setup lang="ts">
import moment from "moment/moment";
import Skeleton from 'primevue/skeleton';
import {computed} from "vue";
import {useStore} from "../../store";

const store = useStore();

const user = computed(() => store.getters.getUser);
</script>

<template>
  <div class="text-gray-700">
    <div class="grid md:grid-cols-2 text-sm mb-2">
      <div class="grid grid-cols-2">
        <div class="px-4 py-2 font-semibold ">First Name</div>
        <Skeleton v-if="!user" class="w-full h-4"/>
        <div v-else class="px-4 py-2 ">{{user?.firstName}}</div>
      </div>
      <div class="grid grid-cols-2">
        <div class="px-4 py-2 font-semibold ">Last Name</div>
        <Skeleton v-if="!user" class="w-full h-4"/>
        <div v-else class="px-4 py-2 ">{{user?.lastName}}</div>
      </div>
      <div class="grid grid-cols-2">
        <div class="px-4 py-2 font-semibold">Gender</div>
        <Skeleton v-if="!user" class="w-full h-4"/>
        <div v-else class="px-4 py-2">{{user?.gender}}</div>
      </div>
      <div class="grid grid-cols-2">
        <div class="px-4 py-2 font-semibold">Contact No.</div>
        <Skeleton v-if="!user" class="w-full h-4"/>
        <div v-else class="px-4 py-2">{{user?.phone}}</div>
      </div>
      <div class="grid grid-cols-2">
        <div class="px-4 py-2 font-semibold">Current Address</div>
        <Skeleton v-if="!user" class="w-full h-4"/>
        <div v-else class="px-4 py-2">{{user?.currentAddress}}</div>
      </div>
      <div class="grid grid-cols-2">
        <div class="px-4 py-2 font-semibold">Permanant Address</div>
        <Skeleton v-if="!user" class="w-full h-4"/>
        <div v-else class="px-4 py-2">{{user?.permanantAddress}}</div>
      </div>
      <div class="grid grid-cols-2">
        <div class="px-4 py-2 font-semibold">Email.</div>
        <Skeleton v-if="!user" class="w-full h-4"/>
        <div v-else class="px-4 py-2">{{user?.email}}</div>
      </div>
      <div class="grid grid-cols-2">
        <div class="px-4 py-2 font-semibold">Birthday</div>
        <Skeleton v-if="!user" class="w-full h-4"/>
        <div v-else class="px-4 py-2">{{moment(user?.birthday).format("MMM D, YYYY")}}</div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>