<script lang="ts" setup>
import ProgressSpinner from 'primevue/progressspinner';
import {useRoute} from "vue-router";

const route = useRoute();
</script>

<template>
  <component :is="route.meta.layout">
    <Suspense>
      <template #fallback>
        <ProgressSpinner/>
      </template>
      <router-view/>
    </Suspense>
  </component>
</template>

