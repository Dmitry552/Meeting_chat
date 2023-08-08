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

<script>
import AddLayoutMixin from "../mixins/AddLayoutMixin.js";
import {useForm} from 'vee-validate';
import {string, object, ref as Ref} from 'yup';
import {ref, computed} from "vue";
import {useI18n} from "vue-i18n";

export default {
  name: "SignUp",
  mixins: [AddLayoutMixin],
  setup() {
    const {t} = useI18n();

    const loading = ref(null);

    const T = computed(() => {
      return {
        email: t('logIn.email'),
        password: t('logIn.password'),
        name: t('registration.name')
      }
    })

    const schema = computed(() => object({
      name: string()
        .required(t('errors.string.required', {value: T.value.name}))
        .min(3, t('errors.string.min', {value: T.value.name, number: 3})),
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

    const {handleSubmit, setFieldError} = useForm({
      validationSchema: schema
    });

    const handleSignUp = handleSubmit(value => {
      console.log(value)
    });

    return {
      handleSignUp,
      loading
    }
  },
  data() {
    return {
      layoutName: 'login'
    }
  }
}
</script>

<style scoped>

</style>