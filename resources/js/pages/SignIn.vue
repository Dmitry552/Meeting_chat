<template>
  <section class="container-lg w-full">
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
                  name="remember"
                  type="checkbox"
                />
                <div class="ml-3 text-sm">
                  <label for="remember" class="text-gray-500 dark:text-gray-400">
                    <!--                      Remember me-->
                    {{$t("logIn['remember']")}}
                  </label>
                </div>
              </div>
              <router-link to="#" class="ml-2 text-sm font-medium text-gray-500 hover:underline dark:text-gray-400">
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

<script>
import AddLayoutMixin from "../mixins/AddLayoutMixin.js";
import {useForm} from 'vee-validate';
import {string, object} from 'yup';
import {useI18n} from "vue-i18n";
import {computed, ref} from "vue";

export default {
  name: "LogIn",
  mixins: [AddLayoutMixin],
  setup() {
    const {t} = useI18n();

    const loading = ref(null);

    const T = computed(() => {
      return {
        email: t('logIn.email'),
        password: t('logIn.password'),
      }
    })

    const schema = computed(() => object({
        email: string()
          .required(t('errors.string.required', {value: T.value.email}))
          .email(t('errors.string.email')),
        password: string()
          .required(t('errors.string.required', {value: T.value.password}))
          .min(8, t('errors.string.min', {value: T.value.password, number: 8})),
      })
    );

    const {handleSubmit, setFieldError} = useForm({
      validationSchema: schema
    });

    const handleSignIn = handleSubmit(value => {
      console.log(value)
    });

    return {
      handleSignIn,
      loading
    }
  },
  data() {
    return {
      layoutName: 'login',
    }
  }
}
</script>

<style scoped>

</style>