import {TCustomAction} from "../../types";
import {TAuthState} from "./";
import * as types from './mutationsAuthTypes';
import {$authHttp, $http} from "../../../utils/http";

export const registrationUser: TCustomAction<TAuthState> = ({commit}, payload): Promise<void> => {
  return new Promise((resolve, reject): void => {
    $http.post('api/registration', payload)
      .then(({data}) => {
        commit(types.SAVE_AUTH_TOKEN, {token: data.access_token});
        localStorage.setItem('token', data.access_token);
        resolve(data);
      })
      .catch(error => {
        reject(error.response);
      });
  });
}

export const login: TCustomAction<TAuthState> = ({commit}, payload): Promise<void> => {
  return new Promise((resolve, reject): void => {
    $http.post('api/login', payload)
      .then(({data}) => {
        commit(types.SAVE_AUTH_TOKEN, {token: data.access_token});
        localStorage.setItem('token', data.access_token);
        resolve(data);
      })
      .catch(error => {
        reject(error.response);
      });
  });
}

export const getAuthUser: TCustomAction<TAuthState> = ({commit}): Promise<void> => {
  return new Promise((resolve, reject): void => {
    $authHttp.get('api/user/me')
      .then(({data}) => {
        commit(types.SAVE_AUTH_USER, {authUser: data});
        resolve(data);
      })
      .catch(error => {
        if (error.response.status === 401) {
          commit(types.REMOVE_AUTH_TOKEN);
          commit(types.REMOVE_AUTH_USER);
          localStorage.removeItem('token');
        }
        reject(error.response);
      });
  });
}

export const logout: TCustomAction<TAuthState> = ({commit}): Promise<void> => {
  return new Promise((resolve, reject): void => {
    $authHttp.post('api/user/logout')
      .then(() => {
        commit(types.REMOVE_AUTH_TOKEN);
        commit(types.REMOVE_AUTH_USER);
        localStorage.removeItem('token');
        resolve();
      })
      .catch(error => {
        reject(error.response);
      });
  });
}

export const refreshToken: TCustomAction<TAuthState> = ({commit}): Promise<void> => {
  return new Promise((resolve, reject): void => {
    $authHttp.post('api/user/refresh')
      .then(({data}) => {
        commit(types.SAVE_AUTH_TOKEN, {token: data.access_token});
        localStorage.setItem('token', data.access_token);
        resolve(data);
      })
      .catch(error => {
        reject(error.response);
      });
  });
}

export const forgotPassword: TCustomAction<TAuthState> = ({commit}, payload): Promise<void> => {
  return new Promise((resolve, reject): void => {
    $http.post('api/forgot-password', payload)
      .then(({data}) => {
        resolve(data);
      })
      .catch(error => {
        reject(error.response);
      });
  });
}

export const resetPassword: TCustomAction<TAuthState> = ({commit}, payload): Promise<void> => {
  return new Promise((resolve, reject): void => {
    $http.post('api/reset-password', payload)
      .then(({data}) => {
        resolve(data);
      })
      .catch(error => {
        reject(error.response);
      });
  });
}

export const getSSOData: TCustomAction<TAuthState> = ({commit}, payload): Promise<void> => {
  return new Promise((resolve, reject): void => {
    $http.post('api/socialUserData', payload)
      .then(({data}) => {
        commit(types.SAVE_AUTH_TOKEN, {token: data.access_token});
        localStorage.setItem('token', data.access_token);
        resolve(data);
      })
      .catch(error => {
        reject(error.response);
      });
  });
}