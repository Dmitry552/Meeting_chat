import {TCustomAction} from "../../types";
import {$authHttp, $http} from "../../../utils/http";
import * as types from "./mutationsInterlocutorType";
import {TInterlocutorState} from "./index";
import {TCreateInterlocutorData} from "./types";
import {Commit} from "vuex";

export const createInterlocutor: TCustomAction<TInterlocutorState> = (
  {commit}: {commit: Commit},
  payload: TCreateInterlocutorData
): Promise<void> => {
  return new Promise((resolve, reject) => {
    if (payload.userName) {
      $http.post(`/api/interlocutor`, payload)
        .then(({data}) => {
          commit(types.GET_CURRENT_INTERLOCUTOR, data);
          localStorage.setItem('currentInterlocutor', data.code);
          resolve(data);
        }).catch(err => {
        reject(err);
      })
    } else {
      $authHttp.post(`/api/interlocutor`, payload)
        .then(({data}) => {
          commit(types.GET_CURRENT_INTERLOCUTOR, data);
          localStorage.setItem('currentInterlocutor', data.code);
          resolve();
        }).catch(err => {
        reject(err);
      })
    }
  });
}

export const removeInterlocutor: TCustomAction<TInterlocutorState> = (
  {commit}: {commit: Commit},
  payload: string
): Promise<void> => {
  return new Promise((resolve, reject) => {
    $http.delete(`/api/interlocutor/${payload}`)
      .then(({data}) => {
        commit(types.REMOVE_CURRENT_INTERLOCUTOR);
        commit(types.REMOVE_INTERLOCUTOR, data.code);
        resolve();
      }).catch(err => {
      reject(err);
    })
  });
}

export const getInterlocutorsRoom: TCustomAction<TInterlocutorState> = (
  {commit}: {commit: Commit},
  payload: string
): Promise<void> => {
  return new Promise((resolve, reject) => {
    $http.get(`/api/room/interlocutors/${payload}`)
      .then(({data}) => {
        commit(types.GET_INTERLOCUTORS, data);
        resolve();
      }).catch(() => {
      reject();
    })
  });
}

export const getInterlocutor: TCustomAction<TInterlocutorState> = (
  {commit}: {commit: Commit},
  payload: string
): Promise<void> => {
  return new Promise((resolve, reject) => {
    $http.get(`/api/interlocutor/${payload}`)
      .then(({data}) => {
        commit(types.APP_INTERLOCUTOR, data);
        resolve(data);
      }).catch((err) => {
      reject(err);
    })
  });
}
