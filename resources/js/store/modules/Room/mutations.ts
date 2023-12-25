import * as types from "./mutationsRoomTypes";
import {TRoomState} from "./index";

export default {
  [types.GET_ROOM]: (state: TRoomState, payload): void => {
    state.room = payload;
  },
  [types.GET_INTERLOCUTORS]: (state: TRoomState, payload): void => {
    state.interlocutors = payload;
  },
  [types.GET_CURRENT_INTERLOCUTOR]: (state: TRoomState, payload): void => {
    state.currentInterlocutor = payload;
  }
}
