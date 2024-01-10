import * as types from "./mutationsInterlocutorType";
import {store} from '../../';
import {TInterlocutorState} from "./index";
import {Interlocutor} from '../../../types';

export default {
  [types.GET_INTERLOCUTORS]: (state: TInterlocutorState, payload: Interlocutor[]): void => {
    state.interlocutors = payload;
  },
  [types.APP_INTERLOCUTOR]: (state: TInterlocutorState, payload: Interlocutor): void => {
    if (!state.interlocutors) {
      state.interlocutors = [payload];
    } else {
      state.interlocutors!.push(payload);
    }
  },
  [types.SET_INTERLOCUTORS]: (state: TInterlocutorState, payload: Interlocutor[]): void => {
    state.interlocutors = [...payload];
  },
  [types.REMOVE_INTERLOCUTOR]: (state: TInterlocutorState, payload: string): void => {
    state.interlocutors = state.interlocutors!.filter(
      (interlocutor: Interlocutor): boolean => interlocutor.code !== payload
    );
  },
  [types.REMOVE_INTERLOCUTORS]: (state: TInterlocutorState): void => {
    state.interlocutors = null;
    state.currentInterlocutor = null;
  },
  [types.GET_CURRENT_INTERLOCUTOR]: (state: TInterlocutorState, payload: Interlocutor): void => {
    state.currentInterlocutor = payload;
  },
  [types.REMOVE_CURRENT_INTERLOCUTOR]: (state: TInterlocutorState): void => {
    state.currentInterlocutor = null;
  },
  [types.UPDATE_INTERLOCUTOR]: (state: TInterlocutorState, payload: Interlocutor): void => {
    state.interlocutors!.forEach(
      (interlocutor: Interlocutor) => {
        if (interlocutor.code === payload.code) {
          return payload;
        }
      }
    );
  },
}

export const updateInterlocutor = (data: Interlocutor) => store.commit(
  types.UPDATE_INTERLOCUTOR,
  data
);
export const removeInterlocutor = (data: string) => store.commit(
  types.REMOVE_INTERLOCUTOR,
  data
)
export const removeInterlocutors = () => store.commit(
  types.REMOVE_INTERLOCUTORS
)
export const setInterlocutors = (data: Interlocutor[]) => store.commit(
  types.SET_INTERLOCUTORS,
  data
);
export const setCurrentInterlocutor = (data: Interlocutor) => store.commit(
  types.GET_CURRENT_INTERLOCUTOR,
  data
);