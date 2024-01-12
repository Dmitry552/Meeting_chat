import {TCustomAction} from "../../types";
import {TRoomState} from "./";
import {$http} from "../../../utils/http";
import * as types from './mutationsRoomTypes';
import {TCreateRoomData, TJoinRoomData} from "./types";
import {Commit} from "vuex";

export const createRoom: TCustomAction<TRoomState> = (
  {commit, getters}: {commit: Commit, getters: any},
  payload: TCreateRoomData
): Promise<void> => {
  return new Promise((resolve, reject): void => {
    const creator = getters.getCurrentInterlocutor;

    $http.post(`/api/room/${creator.id}`, payload)
      .then((): void => {
        resolve();
      }).catch(err => {
      reject(err);
    });
  })
}

export const joinRoom: TCustomAction<TRoomState> = (
  {commit}: {commit: Commit},
  payload: TJoinRoomData
): Promise<void> => {
  return new Promise((resolve, reject): void => {
    $http.get(`/api/room/join/${payload.roomId}/${payload.interlocutor}`)
      .then((): void => {
        resolve();
      }).catch(err => {
      reject(err);
    });
  })
}

export const checkRoom: TCustomAction<TRoomState> = (
  {commit}: {commit: Commit},
  payload: string
): Promise<boolean> => {
  return new Promise((resolve, reject): void => {
    $http.get(`/api/room/check/${payload}`)
      .then(({data}): void => {
        resolve(Boolean(data));
      }).catch((): void => {
      reject();
    })
  });
}

export const getRoom: TCustomAction<TRoomState> = (
  {commit}: {commit: Commit},
  payload: string
): Promise<void> => {
  return new Promise((resolve, reject): void => {
    $http.get(`/api/room/${payload}`)
      .then(({data}): void => {
        commit(types.GET_ROOM, data);
        resolve(data);
      }).catch((): void => {
      reject();
    })
  });
}
