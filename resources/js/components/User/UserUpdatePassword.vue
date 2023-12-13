<script setup lang="ts">
import {computed} from "vue";
import * as yup from "yup";
import {useForm} from "vee-validate";
import {ref as Ref, string} from "yup";
import {useStore} from "../../store";
import {errorHandler} from "../../utils/helpers";

type TSchema = {
  oldPassword: string,
  password: string,
  password_confirmation: string
}

type TData = {
  id: number
} & TSchema

const emits = defineEmits<{
  (e: 'close'): void
}>();

const store = useStore();

const user = computed(() => store.getters.getUser);

const uploadPassword = (data: TData) => store.dispatch('uploadPassword', data);

const schema = computed(() => yup.object({
  oldPassword: yup.string(),
  password: string()
    .required()
    .min(8),
  password_confirmation: string()
    .required()
    .min(8)
    .oneOf([Ref('password')]),
}))

const {handleSubmit, defineField, errors, resetForm} = useForm<TSchema>({
  validationSchema: schema,
});

const [oldPassword] = defineField('oldPassword');
const [password] = defineField('password');
const [passwordConfirm] = defineField('password_confirmation');

const handleRejectChanges = () => {
  resetForm();
  emits('close');
}

const handleConfirmationChanges = handleSubmit((event) => {
  const data = {
    ...event,
    id: user.value.id
  }

  uploadPassword(data).catch(err => {
    errorHandler(err.response);
  })
})
</script>

<template>
  <form>
    <div class="text-gray-700">
      <div class="grid xl:grid-cols-2 text-sm">
        <div class="grid grid-cols-4 relative">
          <div class="px-4 py-1 font-semibold">Old Password</div>
          <Password
            class="mb-5 w-full h-10 col-span-3 "
            v-model="oldPassword"
            toggleMask
            :feedback="false"
            :pt="{
              input: {class: `px-2 py-1 w-full bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
                outline-none focus:ring-2 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600
                dark:placeholder-gray-400 dark:text-white dark:focus:ring-2 dark:focus:ring-blue-500`}
            }"
          />
          <span class="text-sm text-red-500 absolute -bottom-0 right-3">{{errors.oldPassword}}</span>
        </div>
        <div class="grid grid-cols-4 relative">
          <div class="px-4 py-1 font-semibold ">New Password</div>
          <Password
            class="mb-5 w-full h-10 col-span-3 "
            v-model="password"
            toggleMask
            :feedback="false"
            :pt="{
              input: {class: `px-2 py-1 w-full bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
                outline-none focus:ring-2 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600
                dark:placeholder-gray-400 dark:text-white dark:focus:ring-2 dark:focus:ring-blue-500`}
            }"
          />
          <span class="text-sm text-red-500 absolute -bottom-0 right-3">{{errors.password}}</span>
        </div>
        <div class="grid grid-cols-4 relative">
          <div class="px-4 py-1 font-semibold ">Confirm Password</div>
          <Password
            class="mb-5 w-full h-10 col-span-3 "
            v-model="passwordConfirm"
            toggleMask
            :feedback="false"
            :pt="{
                input: {class: `px-2 py-1 w-full bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
                  outline-none focus:ring-2 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600
                  dark:placeholder-gray-400 dark:text-white dark:focus:ring-2 dark:focus:ring-blue-500`}
              }"
          />
          <span class="text-sm text-red-500 absolute -bottom-0 right-3">{{errors.password_confirmation}}</span>
        </div>
      </div>
    </div>
    <div class="flex gap-4 justify-center mt-2">
      <ui-button @click.prevent="handleRejectChanges">Cancel</ui-button>
      <ui-button @click.prevent="handleConfirmationChanges">Ok</ui-button>
    </div>
  </form>
</template>

<style scoped>

</style>