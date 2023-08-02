<template>
  <section class="">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <div class="w-full bg-white rounded-lg shadow-md dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800
           dark:border-gray-700">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
          <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-500 dark:text-gray-400">
            {{$t("logIn['sign in to']")}}
          </h1>
          <form class="space-y-4 md:space-y-6" action="#">
            <div>
              <label for="email" class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">
                {{$t("logIn['email']")}}
              </label>
              <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-500
              sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700
              dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500
              dark:focus:border-blue-500" placeholder="name@company.com">
            </div>
            <ui-password v-model="password">
              {{$t("logIn['password']")}}
            </ui-password>
            <div class="flex items-center justify-between">
              <div class="flex items-start">
                <div class="flex items-center h-5">
                  <input id="remember" aria-describedby="remember" type="checkbox"
                         class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300
                         dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800"
                         required="">
                </div>
                <div class="ml-3 text-sm">
                  <label for="remember" class="text-gray-500 dark:text-gray-400">{{$t("logIn['remember']")}}</label>
                </div>
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
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import AddLayoutMixin from "../mixins/AddLayoutMixin.js";

export default {
  name: "LogIn",
  mixins: [AddLayoutMixin],
  data() {
    return {
      layoutName: 'login',
      password: ''
    }
  },
  created() {

  }
}
</script>

<style scoped>

</style>