import axios, {InternalAxiosRequestConfig} from "axios";
import getLocalization from "./localization";

const $http = axios.create({
  baseURL: import.meta.env.VITE_APP_URL,
});

const $authHttp = axios.create({
  baseURL: import.meta.env.VITE_APP_URL,
})

$http.interceptors.request.use( (value: InternalAxiosRequestConfig ): InternalAxiosRequestConfig =>  {
  value.headers['Accept-Language'] = getLocalization();
  return value;
});
$authHttp.interceptors.request.use((value: InternalAxiosRequestConfig ): InternalAxiosRequestConfig => {
  value.headers['Accept-Language'] = getLocalization();
  value.headers['Authorization'] = `Bearer ${localStorage.getItem('token')}`
  return value;
});

export {
  $http,
  $authHttp
}