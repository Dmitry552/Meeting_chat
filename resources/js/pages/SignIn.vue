<script lang="ts" setup>
import {useForm} from 'vee-validate';
import {string, object, ObjectSchema} from 'yup';
import {useI18n} from "vue-i18n";
import {computed, ref} from "vue";
import {useStore} from "../store";
import swal from 'sweetalert';
import {useRouter} from "vue-router";
import {errorHandler} from "../utils/helpers";
import SocialPanel from "../components/SocialPanel.vue";

type TSchema = {
  email: string,
  password: string
}

type TLoginData = {
  remember_me: boolean
} & TSchema

type TSSOData = {
  provider: string,
  token?: string,
  code?: string
}

const {t} = useI18n();
const {push} = useRouter();
const store = useStore();

const loading = ref<boolean>(false);
const IName = 'login';

defineExpose({IName});

const T = computed<{email: string, password: string}>(() => {
  return {
    email: t('logIn.email'),
    password: t('logIn.password'),
  }
})

const schema = computed<ObjectSchema<TSchema>>(() => object({
    email: string()
      .required(t('errors.string.required', {value: T.value.email}))
      .email(t('errors.string.email')),
    password: string()
      .required(t('errors.string.required', {value: T.value.password}))
      .min(3, t('errors.string.min', {value: T.value.password, number: 8})),
  })
);

const {handleSubmit, setFieldError} = useForm<TSchema>({
  validationSchema: schema,
  initialValues: {
    email: '',
    password: '',
  }
});

const authUser = (data: TLoginData) => store.dispatch('login', data);
const getSSOData = (data: TSSOData) => store.dispatch('getSSOData', data);

const handleSignIn = handleSubmit(value => {
  loading.value = true;
  authUser(value as TLoginData)
    .then(() => {
      swal({
        title: "Ok!",
        icon: "success",
      }).then(() => {
        push('/');
      });
  }).catch((err) => {
    errorHandler(err, setFieldError);
  }).finally(() => loading.value = false);
});

const handleLoginGoogle = (response: any) => {
  loading.value = true;
  getSSOData({
      provider: 'google',
      token: response.access_token
    }).then(({data}) => {
      console.log('google', data);
      swal({
        title: "Ok!",
        icon: "success",
      }).then(() => {
        push('/');
      });
    }).catch(err => {
      errorHandler(err);
    }).finally(() => loading.value = false);
}

const handleLoginFacebook = () => {
  const link = document.createElement('a');
  link.href = `${import.meta.env.VITE_APP_URL}/auth/facebook/redirect`;
  link.click();
}
</script>

<template>
  <section class="container">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <div
        class="w-full bg-white rounded-lg shadow-md dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800
           dark:border-gray-700"
      >
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
          <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-500 dark:text-gray-400">
            <!--            Sign in to your account-->
            {{$t("logIn['sign in to']")}}
          </h1>
          <form
            class="space-y-4 md:space-y-6"
            @submit.prevent="handleSignIn"
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
            <div class="flex items-center justify-between">
              <div class="flex items-start">
                <ui-input-text
                  name="remember_me"
                  type="checkbox"
                />
                <div class="ml-3 text-sm">
                  <label for="remember_me" class="text-gray-500 dark:text-gray-400">
                    <!--                      Remember me-->
                    {{$t("logIn['remember']")}}
                  </label>
                </div>
              </div>
              <router-link to="/password/forgot" class="ml-2 text-sm font-medium text-gray-500 hover:underline dark:text-gray-400">
                <!--                Forgot password?-->
                {{$t("logIn['forgot']")}}
              </router-link>
            </div>
            <ui-button
              :loading="loading"
            >
              <!--              Sign in-->
              {{$t("logIn['sign in']")}}
            </ui-button>
            <social-panel @googleLogin="handleLoginGoogle"/>
            <p class="text-sm font-light text-gray-500 dark:text-gray-400">
              <!--              Don’t have an account yet?-->
              {{$t("logIn['do not account']")}}
              <router-link to="/sign-up" class="font-medium text-primary-600 hover:underline dark:text-primary-500">
                <!--                Sign up-->
                {{$t("logIn['sign up']")}}
              </router-link>
            </p>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>

</style>