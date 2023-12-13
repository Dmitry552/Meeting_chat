<script lang="ts" setup>
import {useForm} from 'vee-validate';
import {string, object, ref as Ref, ObjectSchema} from 'yup';
import {ref, computed} from "vue";
import {useI18n} from "vue-i18n";
import swal from "sweetalert";
import {errorHandler} from "../utils/helpers";
import {useStore} from "../store";
import {useRouter} from "vue-router";

type TSchema = {
  name: string,
  email: string,
  password: string,
  password_confirmation: string
}

type TRegistrationData = {
  remember_me: boolean
} & TSchema

const {t} = useI18n();
const store = useStore();
const {push} = useRouter();

const loading = ref<boolean>(false);

const T = computed<{email: string, password: string, name: string}>(() => {
  return {
    email: t('logIn.email'),
    password: t('logIn.password'),
    name: t('registration.name')
  }
})

const schema = computed<ObjectSchema<TSchema>>(() => object({
  name: string()
    .required(t('errors.string.required', {value: T.value.name}))
    .min(3, t('errors.string.min', {value: T.value.name, number: 3})),
  email: string()
    .required(t('errors.string.required', {value: T.value.email}))
    .email(t('errors.string.email')),
  password: string()
    .required(t('errors.string.required', {value: T.value.password}))
    .min(8, t('errors.string.min', {value: T.value.password, number: 8})),
  password_confirmation: string()
    .required(t('registration.passwordConfirm'))
    .min(8, t('errors.string.min', {value: T.value.password, number: 8}))
    .oneOf([Ref('password')], t('errors.string.oneOf')),
  })
);

const {handleSubmit, setFieldError} = useForm<TSchema>({
  validationSchema: schema,
  initialValues: {
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
  }
});

const registerUser = (data: TRegistrationData) => store.dispatch('registrationUser', data);

const handleSignUp = handleSubmit(value => {
  loading.value = true;
  registerUser(value as TRegistrationData)
    .then(() => {
      loading.value = false;
      swal({
        title: "Ok!",
        icon: "success",
      }).then(() => {
        push('/');
      });
    }).catch((err) => {
    errorHandler(err, setFieldError);
  });
});

</script>

<template>
  <section class="container-lg w-full">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <div class="w-full p-6 bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md dark:bg-gray-800
            dark:border-gray-700 sm:p-8"
      >
        <h2 class="mb-1 text-xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white">
          {{$t("registration.register")}}
        </h2>
        <form
          class="mt-4 space-y-4 lg:mt-5 md:space-y-5 "
          @submit.prevent="handleSignUp"
        >
          <div>
            <ui-input-text
              :title="$t('registration.name')"
              name="name"
              :required="true"
            />
          </div>
          <div>
            <ui-input-text
              :title="$t('logIn.email')"
              type="email"
              name="email"
              placeholder="name@company.com"
              :required="true"
            />
          </div>
          <div>
            <ui-input-text
              :title="$t('logIn.password')"
              type="password"
              name="password"
              placeholder="••••••••"
              :required="true"
            />
          </div>
          <div>
            <ui-input-text
              :title="$t('registration.passwordConfirm')"
              type="password"
              name="passwordConfirm"
              placeholder="••••••••"
              :required="true"
            />
          </div>
          <div class="flex items-start">
            <div class="flex items-center h-5">
              <ui-input-text
                name="newsletter"
                type="checkbox"
              />
            </div>
            <div class="ml-3 text-sm">
              <label
                for="newsletter"
                class="font-light text-gray-500 dark:text-gray-300"
              >
                {{$t("registration['i accept']")}}
                <router-link to="#" class="font-medium text-primary-600 hover:underline dark:text-primary-500">
                  {{$t("registration.terms")}}
                </router-link>
              </label>
            </div>
          </div>
          <ui-button
            :loading="loading"
          >
            {{$t("logIn['sign up']")}}
          </ui-button>
        </form>

      </div>
    </div>
  </section>
</template>

<style scoped>

</style>