<template>
  <section>
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <div
        class="w-full bg-white rounded-lg shadow-md dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800
           dark:border-gray-700"
      >
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
          <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-500 dark:text-gray-400">
            {{$t("logIn['sign in to']")}}
          </h1>
          <Form
            class="space-y-4 md:space-y-6"
            @submit="handleSignIn"
            :validation-schema="schema"
            v-slot="{errors}"
          >
            <div :class="{['group error']: errors.email}">
              <label
                for="email"
                class="after:content-['*'] after:ml-0.5 after:text-red-500 block mb-2 text-sm
                  font-medium text-gray-500 dark:text-gray-400"
              >
                {{t.email}}
              </label>
              <Field
                class="bg-gray-50 border border-gray-300 text-gray-500
                  sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400
                  dark:focus:ring-blue-500 dark:focus:border-blue-500 group-[.error]:border-red-500"
                placeholder="name@company.com"
                type="email"
                name="email"
              />
              <ErrorMessage name="email" class="text-sm text-red-500"/>
            </div>
            <Field name="password" v-slot="{ handleChange, value}">
              <ui-password
                :error="Boolean(errors.password)"
                :modelValue="value"
                @update:modelValue="handleChange"
              >
                {{t.password}}
              </ui-password>
            </Field>
            <ErrorMessage name="password" class="text-sm text-red-500"/>
            <div class="flex items-center justify-between">
              <div class="flex items-start">
                <Field v-slot="{ field }" name="remember" type="checkbox" :value="true">
                  <div class="flex items-center h-5">
                    <input
                      v-bind="field"
                      name="remember"
                      id="remember"
                      aria-describedby="remember"
                      type="checkbox"
                      class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300
                       dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800"
                    >
                  </div>
                  <div class="ml-3 text-sm">
                    <label for="remember" class="text-gray-500 dark:text-gray-400">{{$t("logIn['remember']")}}</label>
                  </div>
                </Field>
              </div>
              <router-link to="#" class="ml-2 text-sm font-medium text-gray-500 hover:underline dark:text-gray-400">
                {{$t("logIn['forgot']")}}
              </router-link>
            </div>
            <ui-button>
              {{$t("logIn['sign in']")}}
            </ui-button>
            <p class="text-sm font-light text-gray-500 dark:text-gray-400">
              {{$t("logIn['do not account']")}}
              <router-link to="#" class="font-medium text-primary-600 hover:underline dark:text-primary-500">
                {{$t("logIn['sign up']")}}
              </router-link>
            </p>
          </Form>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import AddLayoutMixin from "../mixins/AddLayoutMixin.js";
import { Form, Field, ErrorMessage } from 'vee-validate';
import {string, object} from 'yup';

export default {
  name: "LogIn",
  mixins: [AddLayoutMixin],
  components: {Form, Field, ErrorMessage},
  data() {
    return {
      layoutName: 'login',
    }
  },
  methods: {
    handleSignIn(results) {
      console.log(results)
      //TODO: Добавить обработку отправки данных
    }
  },
  computed: {
    t() {
      return {
        email: this.$t("logIn['email']"),
        password: this.$t("logIn['password']")
      }
    },
    schema() {
      return object({
        email: string()
          .required(this.$t('errors.string.required', {value: this.t.email}))
          .email(this.$t('errors.string.email')),
        password: string()
          .required(this.$t('errors.string.required', {value: this.t.password}))
          .min(8, this.$t('errors.string.min', {value: this.t.password, number: 8})),
      })
    }
  }
}
</script>

<style scoped>

</style>