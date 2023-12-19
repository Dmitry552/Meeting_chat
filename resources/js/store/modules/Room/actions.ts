import {TCustomAction} from "../../types";
import {TRoomState} from "./";
import {$authHttp, $http} from "../../../utils/http";
import * as types from './mutationsRoomTypes';


export const joinRoom: TCustomAction<TRoomState> = ({commit, getters}, payload): Promise<void> => {
  return new Promise((resolve, reject) => {
    const creator = getters.getCurrentInterlocutor;

    $http.post(`/api/room/${creator.id}`, payload)
      .then(({data}) => {
        console.log('room', data);
        commit(types.GET_ROOM, data);
        resolve();
      }).catch(err => {
      reject(err);
    });
  })
}

export const createInterlocutor: TCustomAction<TRoomState> = ({commit}, payload): Promise<void> => {
  return new Promise((resolve, reject) => {
    if (payload.userName) {
      $http.post(`/api/interlocutor`, payload)
        .then(({data}) => {
          commit(types.GET_CURRENT_INTERLOCUTOR, data);
          resolve(data);
        }).catch(err => {
        reject(err);
      })
    } else {
      $authHttp.post(`/api/interlocutor`, payload)
        .then((data) => {
          commit(types.GET_CURRENT_INTERLOCUTOR, data);
          resolve();
        }).catch(err => {
        reject(err);
      })
    }
  });
}

export const checkRoom: TCustomAction<TRoomState> = ({commit}, payload): Promise<void> => {
  return new Promise((resolve, reject) => {
    $http.get(`/api/room/check/${payload}`)
      .then(() => {
        resolve();
      }).catch(() => {
      reject();
    })
  });
}

export const getRoom: TCustomAction<TRoomState> = ({commit}, payload): Promise<void> => {
  return new Promise((resolve, reject) => {
    $http.post(`/api/room/${payload}`)
      .then(({data}) => {
        console.log('getRoom', data);
        resolve();
      }).catch(() => {
      reject();
    })
  });
}
