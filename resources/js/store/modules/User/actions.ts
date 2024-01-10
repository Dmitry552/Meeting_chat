import * as types from './mutationsUserTypes';
import {TCustomAction} from "../../types";
import {TUserState} from "./";
import {$authHttp} from "../../../utils/http";

export const uploadUser: TCustomAction<TUserState> = ({commit}, payload): Promise<void> => {
  return new Promise((resolve, reject) => {
    const id = payload.id;
    delete payload.id;

    $authHttp.put(`/api/user/${id}`, payload)
      .then(({data}) => {
        commit(types.GET_USER, data);
        resolve();
      }).catch(err => {
      reject(err)
    })
  });
}

export const uploadAvatar: TCustomAction<TUserState> = ({commit}, payload): Promise<void> => {
  return new Promise((resolve, reject) => {
    $authHttp.post(`/api/user/avatar`, payload)
      .then(({data}) => {
        commit(types.GET_USER, data);
        resolve();
      }).catch(err => {
      reject(err)
    })
  });
}

export const uploadPassword: TCustomAction<TUserState> = ({commit}, payload): Promise<void> => {
  return new Promise((resolve, reject) => {
    const id = payload.id;
    delete payload.id;

    $authHttp.post(`/api/user/password/${id}`, payload)
      .then(() => {
        resolve();
      }).catch(err => {
      reject(err)
    })
  });
}

export const getUser: TCustomAction<TUserState> = ({commit}, payload): Promise<any> => {
 return new Promise((resolve, reject) => {
  $authHttp.get(`/api/user/${payload}`)
    .then(({data}) => {
      commit(types.GET_USER, data);
      resolve(data);
    }).catch(err => {
     reject(err)
    })
 });
}
