import {TCustomAction} from "../../types";
import {Interlocutor, Room} from '../../../types';
import {$action} from "../../../utils/http";
import {TMuteData, TTranslationIceData, TTranslationSpdData} from "./types";

export const joined: TCustomAction<any> = (
  {getters}: {getters: any}
): Promise<void> => {
  return new Promise((resolve, reject): void => {
    const currentInterlocutor: Interlocutor = getters.getCurrentInterlocutor;
    const room: Room = getters.getRoom;

    $action.get(`/api/videoChat/join/${room.name}/${currentInterlocutor.code}`)
      .then((): void => {
        resolve();
      }).catch((): void => {
      reject();
    })
  });
}

export const leave: TCustomAction<any> = (
  {getters}: {getters: any}
): Promise<void> => {
  return new Promise((resolve, reject): void => {
    const currentInterlocutor: Interlocutor = getters.getCurrentInterlocutor;
    const room: Room = getters.getRoom;

    $action.get(`/api/videoChat/leave/${room.name}/${currentInterlocutor.code}`)
      .then((): void => {
        resolve();
      }).catch((): void => {
      reject();
    })
  });
}

export const translationIce: TCustomAction<any> = (
  {getters}: {getters: any},
  payload: TTranslationIceData
): Promise<void> => {
  return new Promise((resolve, reject): void => {
    const currentInterlocutor: Interlocutor = getters.getCurrentInterlocutor;
    const room: Room = getters.getRoom;

    $action.post(`/api/videoChat/relayIce/${room.name}/${currentInterlocutor.code}`, payload)
      .then((): void => {
        resolve();
      }).catch((): void => {
      reject();
    })
  });
}

export const translationSdp: TCustomAction<any> = (
  {getters}: {getters: any},
  payload: TTranslationSpdData
): Promise<void> => {
  return new Promise((resolve, reject): void => {
    const currentInterlocutor: Interlocutor = getters.getCurrentInterlocutor;
    const room: Room = getters.getRoom;

    $action.post(`/api/videoChat/relaySdp/${room.name}/${currentInterlocutor.code}`, payload)
      .then((): void => {
        resolve();
      }).catch((): void => {
      reject();
    })
  });
}

export const mute: TCustomAction<any> = (
  {getters}: {getters: any},
  payload: TMuteData
): Promise<void> => {
  return new Promise((resolve, reject): void => {
    const currentInterlocutor: Interlocutor = getters.getCurrentInterlocutor;
    const room: Room = getters.getRoom;

    $action.post(`/api/videoChat/mute/${room.name}/${currentInterlocutor.code}`, payload)
      .then((): void => {
        resolve();
      }).catch((): void => {
      reject();
    })
  });
}
