<script setup lang="ts">
import { ref } from "vue";
import InputMask from "primevue/inputmask";
import Dropdown from "primevue/dropdown";
type TProps = {
  modelValue: string
}

const props = defineProps<TProps>();

const selectedCountry = ref();

const countries = ref([
  { name: 'Australia', countryCode: 'AU', countryCallingCode: '+123' },
  { name: 'Brazil', countryCode: 'BR' },
  { name: 'China', countryCode: 'CN' },
  { name: 'Egypt', countryCode: 'EG' },
  { name: 'France', countryCode: 'FR' },
  { name: 'Germany', countryCode: 'DE' },
  { name: 'India', countryCode: 'IN' },
  { name: 'Japan', countryCode: 'JP' },
  { name: 'Spain', countryCode: 'ES' },
  { name: 'United States', countryCode: 'US' }
]);
</script>

<template>
  <div
    class=""
  >
    <Dropdown
      v-model="selectedCountry"
      :options="countries"
      filter
      optionLabel="name"
      placeholder="Select a Country"
      class="w-full md:w-14rem"
    >
      <template #value="slotProps">
        <div v-if="slotProps.value" class="flex align-items-center">
          <img
            :alt="slotProps.value.label"
            :src="`https://flagcdn.com/${slotProps.value.code.toLowerCase()}.svg`"
            style="width: 18px"
          />
          <div>{{ slotProps.value.name }}</div>
        </div>
        <span v-else>
            {{ slotProps.placeholder }}
        </span>
      </template>
      <template #option="slotProps">
        <div class="flex align-items-center">
          <img
            :alt="slotProps.option.label"
            :src="`https://flagcdn.com/${slotProps.value.code.toLowerCase()}.svg`"
            style="width: 18px"
          />
          <div>{{ slotProps.option.name }}</div>
        </div>
      </template>
    </Dropdown>
    <InputMask
      v-model="props.modelValue"
      mask="(999) 999-9999"
      placeholder="(999) 999-9999"
      :pt="{
          root: () => {
            return {class: `px-2 py-1 mb-5 font-sans text-base text-gray-700 dark:text-white/80
            bg-white dark:bg-gray-900 border border-gray-300 dark:border-blue-900/40
            hover:border-blue-500 focus:outline-none focus:outline-offset-0 focus:shadow-[0_0_0_0.2rem_rgba(191,219,254,1)]
            dark:focus:shadow-[0_0_0_0.2rem_rgba(147,197,253,0.5)] transition duration-200 ease-in-out
            appearance-none rounded-r-lg`}
          }
      }"
    />
  </div>
</template>

<style scoped>

</style>