<script setup lang="ts">
import moment from "moment/moment";
import {useForm} from "vee-validate";
import * as yup from 'yup';
import {computed, ref, watch} from "vue";
import InputText from 'primevue/inputtext';
import Dropdown from 'primevue/dropdown';
import Calendar from 'primevue/calendar';
import Textarea from 'primevue/textarea';
import MazPhoneNumberInput from 'maz-ui/components/MazPhoneNumberInput';
import {useStore} from "../../store";
import {errorHandler} from "../../utils/helpers";

type TSchema = {
  firstName: string,
  lastName: string,
  gender: "Female" | "Male" | "Unknown animal",
  phone: string,
  currentAddress: string,
  permanantAddress: string,
  email: string,
  birthday: string | Date
}

type TData = {
  id: number
} & TSchema

const store = useStore();

const user = computed(() => store.getters.getUser);

const uploadUser = (data: TData) => store.dispatch('uploadUser', data);

const genders = ref<string[]>(['Female', 'Male', 'Unknown animal']);
const phoneValid = ref<boolean>();

const emits = defineEmits<{
  (e: 'close'): void
}>();

const schema = computed(() => yup.object({
  firstName: yup.string(),
  lastName: yup.string(),
  gender: yup.string().required(),
  phone: yup.string(),
  currentAddress: yup.string(),
  permanantAddress: yup.string(),
  email: yup.string().required().email(),
  birthday: yup.string()
}))

const {handleSubmit, defineField, errors, setErrors, resetForm, setFieldError} = useForm<TSchema>({
  validationSchema: schema,
  initialValues: {
    firstName: user.value.firstName,
    lastName: user.value.lastName,
    gender: user.value.gender,
    phone: user.value.phone,
    currentAddress: user.value.currentAddress,
    permanantAddress: user.value.permanantAddress,
    email: user.value.email,
    birthday: moment(user.value.birthday).format("MMM D YYYY")
  }
});

const [firstName] = defineField('firstName');
const [lastName] = defineField('lastName');
const [gender] = defineField('gender');
const [phone] = defineField('phone');
const [currentAddress] = defineField('currentAddress');
const [permanantAddress] = defineField('permanantAddress');
const [email] = defineField('email');
const [birthday] = defineField('birthday');

watch(errors, () => {
  console.log(errors?.value)
})

watch(phoneValid, () => {
  setErrors({
    phone: 'phone must by phoneNumber'
  });
})

const handleRejectChanges = () => {
  resetForm();
  emits('close');
}

const handleConfirmationChanges = handleSubmit((event) => {
  const data = {
    ...event,
    id: user.value.id
  }

  uploadUser(data).catch(err => {
    errorHandler(err, setFieldError);
  });
})
</script>

<template>
  <form>
    <div class="text-gray-700">
      <div class="grid xl:grid-cols-2 text-sm">
        <div class="grid grid-cols-4 relative">
          <div class="px-4 py-1 font-semibold">First Name</div>
          <InputText
            class="h-10 col-span-3 bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg outline-none
              mb-5 px-2 py-1focus:ring-2 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600
              dark:placeholder-gray-400 dark:text-white dark:focus:ring-2 dark:focus:ring-blue-500"
            type="email"
            :class="{'ring-1 ring-red-500 border-red-500': errors.firstName}"
            v-model="firstName"
          />
          <span class="text-sm text-red-500 absolute -bottom-0 right-3">{{errors.firstName}}</span>
        </div>
        <div class="grid grid-cols-4 relative">
          <div class="px-4 py-1 font-semibold ">Last Name</div>
          <InputText
            class="h-10 col-span-3 bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg outline-none mb-5 px-2 py-1
              focus:ring-2 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
              dark:text-white dark:focus:ring-2 dark:focus:ring-blue-500"
            type="email"
            :class="{'ring-1 ring-red-500 border-red-500': errors.lastName}"
            v-model="lastName"
          />
          <span class="text-sm text-red-500 absolute -bottom-0 right-3">{{errors.lastName}}</span>
        </div>
        <div class="grid grid-cols-4">
          <div class="px-4 py-2 font-semibold">Gender</div>
          <Dropdown
            class="col-span-3"
            v-model="gender"
            :options="genders"
            :pt="{
              root: {class: 'mb-5 p-0 w-full h-10 border border-gray-300 text-gray-900 rounded-lg flex block items-center'+
'              justify-between cursor-pointer hover:border-blue-500'},
              input: {class: 'px-2 py-1'}
            }"
          >
            <template #value="slotData">
              <span>{{slotData.value}}</span>
            </template>
          </Dropdown>
          <span class="text-sm text-red-500 absolute -bottom-0 right-3">{{errors.gender}}</span>
        </div>
        <div class="grid grid-cols-4 relative">
          <div class="px-4 py-2 font-semibold">Contact No</div>
          <MazPhoneNumberInput
            class="col-span-3 h-10 mb-5"
            v-model="phone"
            size="sm"
            @update="phoneValid = $event.isValid"
          />
          <span class="text-sm text-red-500 absolute -bottom-0 right-3">{{errors.phone}}</span>
        </div>
        <div class="grid grid-cols-4 relative">
          <div class="px-4 py-2 font-semibold">Current Address</div>
          <Textarea
            v-model="currentAddress"
            class="col-span-3 bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg outline-none
              mb-5 px-2 py-1 focus:ring-2 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600
              dark:placeholder-gray-400 dark:text-white dark:focus:ring-2 dark:focus:ring-blue-500"
            rows="2"
            :class="{'border border-red-500': errors.currentAddress}"
          />
          <span class="text-sm text-red-500 absolute -bottom-0 right-3">{{errors.currentAddress}}</span>
        </div>
        <div class="grid grid-cols-4 relative">
          <div class="px-4 py-2 font-semibold">Permanant Address</div>
          <Textarea
            v-model="permanantAddress"
            class="col-span-3 bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg outline-none
              mb-5 px-2 py-1 focus:ring-2 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600
              dark:placeholder-gray-400 dark:text-white dark:focus:ring-2 dark:focus:ring-blue-500"
            rows="2"
            :class="{'border border-red-500': errors.currentAddress}"
          />
          <span class="text-sm text-red-500 absolute -bottom-0 right-3">{{errors.permanantAddress}}</span>
        </div>
        <div class="grid grid-cols-4 relative">
          <div class="px-4 py-1 font-semibold">Email</div>
          <InputText
            class="h-10 col-span-3 bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg outline-none mb-5 px-2 py-1
              focus:ring-2 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
              dark:text-white dark:focus:ring-2 dark:focus:ring-blue-500"
            type="email"
            :class="{'border border-red-500': errors.email}"
            v-model="email"
          />
          <span class="text-sm text-red-500 absolute -bottom-0 right-3">{{errors.email}}</span>
        </div>
        <div class="grid grid-cols-4">
          <div class="px-4 py-2 font-semibold">Birthday</div>
          <Calendar
            class="col-span-2 h-10 mb-5"
            v-model="birthday"
            showIcon
            iconDisplay="input"
            dateFormat="M dd yy"
            :pt="{
              input: {class: 'px-2 border border-y-gray-300 border-l-gray-300 border-r-0 text-gray-900 rounded-l-lg'},
              dropdownButton: {
                input: {class: 'h-full'},
                root: {class: 'bg-white border border-gray-300 h-10 w-10 rounded-r-lg'}
              }
            }"
          />
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