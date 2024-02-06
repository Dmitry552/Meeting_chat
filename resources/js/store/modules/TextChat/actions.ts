import {TCustomAction} from "../../types";
import {TTextChatState} from "./index";
import {Commit} from "vuex";
import {$action, $http} from '../../../utils/http';
import * as types from './mutationsTextChatType';
import {Interlocutor, Room} from '../../../types';
import {TMessageContent} from "./types";

export const getMessages: TCustomAction<TTextChatState> = (
  {commit, getters}: {commit: Commit, getters: any},
  ): Promise<void> => {
  return new Promise((resolve, reject): void => {
    const room: Room = getters.getRoom;

    $http.get(`/api/textChat/${room.name}`)
      .then(({data}): void => {
        commit(types.GET_MESSAGES, data);
        resolve(data);
      }).catch(err => {
        reject(err.response);
      });

  });
}

export const sendMessage: TCustomAction<TTextChatState> = (
  {commit, getters}: {commit: Commit, getters: any},
  payload: TMessageContent
): Promise<void> => {
  return new Promise((resolve, reject): void => {
    const room: Room = getters.getRoom;
    const currentInterlocutor: Interlocutor = getters.getCurrentInterlocutor;

    $action.post(`/api/textChat/message/${room.name}/${currentInterlocutor.code}`, payload)
      .then(({data}): void => {
        commit(types.ADD_MESSAGE, data);
        resolve(data);
    }).catch(err => {
      reject(err.response);
    })
  });
}
