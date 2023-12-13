<script setup lang="ts">
import {useForm} from 'vee-validate';
import {string, object, ref as Ref, ObjectSchema} from 'yup';
import {ref, computed} from "vue";
import {useI18n} from "vue-i18n";
import {useRoute, useRouter} from "vue-router";
import swal from "sweetalert";
import {errorHandler} from "../utils/helpers";
import {useStore} from "../store";

type TSchema = {
  email: string,
  password: string,
  passwordConfirm: string
}

type TResetPasswordData = {
  token: string
} & TSchema

const {t} = useI18n();
const {params} = useRoute();
const {push} = useRouter();
const store = useStore();

const loading = ref<boolean>(false);

const T = computed<{email: string, password: string, name: string}>(() => {
  return {
    email: t('logIn.email'),
    password: t('logIn.password'),
    name: t('registration.name')
  }
})

const schema = computed<ObjectSchema<TSchema>>(() => object({
    email: string()
      .required(t('errors.string.required', {value: T.value.email}))
      .email(t('errors.string.email')),
    password: string()
      .required(t('errors.string.required', {value: T.value.password}))
      .min(8, t('errors.string.min', {value: T.value.password, number: 8})),
    passwordConfirm: string()
      .required(t('registration.passwordConfirm'))
      .min(8, t('errors.string.min', {value: T.value.password, number: 8}))
      .oneOf([Ref('password')], t('errors.string.oneOf')),
  })
);

const {handleSubmit, setFieldError} = useForm<TSchema>({
  validationSchema: schema,
  initialValues: {
    email: '',
    password: '',
    passwordConfirm: ''
  }
});

const resetPassword = (data: TResetPasswordData) => store.dispatch('resetPassword', data);

const handleSignUp = handleSubmit(value => {
  loading.value = true;
  const data: TResetPasswordData = {
    ...value,
    token: (params.token as string)
  }

  resetPassword(data)
    .then((data) => {
      const text = data.email || data.status;
      const icon = data.email ? "warning" : "success";
      loading.value = false;

      swal({
        text: text,
        icon: icon,
      }).then(() => {
        icon === 'success' && push('/')
      })
    })
    .catch((err) => {
      errorHandler(err, setFieldError);
    })
});

</script>

<template>
  <section class="container-lg w-full">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <div class="w-full p-6 bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md dark:bg-gray-800
            dark:border-gray-700 sm:p-8"
      >
        <h2 class="mb-1 text-xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white">
          {{$t("reset['reset password']")}}
        </h2>
        <form
          class="mt-4 space-y-4 lg:mt-5 md:space-y-5 "
          @submit.prevent="handleSignUp"
        >
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
          <ui-button
            :loading="loading"
          >
            {{$t("reset.reset")}}
          </ui-button>
        </form>
      </div>
    </div>
  </section>
</template>

<style scoped>

</style>