<script setup lang="ts">
import {useForm} from 'vee-validate';
import {string, object, ref as Ref, ObjectSchema} from 'yup';
import {ref, computed} from "vue";
import {useI18n} from "vue-i18n";
import {useRoute, useRouter} from "vue-router";
import {useStore} from "../store";
import {errorHandler} from "../utils/helpers";
import swal from "sweetalert";

type TSchema = {
  email: string,
}

const {t} = useI18n();
const {params} = useRoute();
const {push} = useRouter();
const store = useStore();

const loading = ref<boolean>(false);

const T = computed<{email: string}>(() => {
  return {
    email: t('logIn.email'),
  }
})

const schema = computed<ObjectSchema<TSchema>>(() => object({
    email: string()
      .required(t('errors.string.required', {value: T.value.email}))
      .email(t('errors.string.email')),
  })
);

const {handleSubmit, setFieldError} = useForm<TSchema>({
  validationSchema: schema,
  initialValues: {
    email: ''
  }
});

const forgotPassword = (data: TSchema) => store.dispatch('forgotPassword', data);

const handleSignUp = handleSubmit(value => {
  loading.value = true;

  forgotPassword(value)
    .then((data) => {
      const text = data.email || data.status;
      const icon = data.email ? "warning" : "success";
      loading.value = false;

      swal({
        text: text,
        icon: icon,
      }).then(() => {
        icon === 'success' && push('/sign-in')
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
        <h2 class="mb-4 text-xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white">
          {{$t("forgotPassword['forgot password']")}}
        </h2>
        <h4 class="mb-4 text-center font-bold leading-tight tracking-tight text-gray-900 dark:text-white">
          {{$t("forgotPassword.description")}}
        </h4>
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

          <ui-button
            :loading="loading"
          >
            {{$t("forgotPassword.forgot")}}
          </ui-button>
        </form>
        <p class="mt-2 text-sm font-light text-gray-500 dark:text-gray-400">
          <!--              Don’t have an account yet?-->
          {{$t("logIn['do not account']")}}
          <router-link to="/sign-up" class="font-medium text-primary-600 hover:underline dark:text-primary-500">
            <!--                Sign up-->
            {{$t("logIn['sign up']")}}
          </router-link>
        </p>
      </div>
    </div>
  </section>
</template>

<style scoped>

</style>