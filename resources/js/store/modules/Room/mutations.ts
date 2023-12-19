import * as types from "./mutationsRoomTypes";
import {TRoomState} from "./index";

export default {
  [types.GET_ROOM]: (state: TRoomState, payload): void => {
    state.room = payload;
    state.interlocutors = payload.interlocutors;
  },
  [types.GET_CURRENT_INTERLOCUTOR]: (state: TRoomState, payload): void => {
    state.currentInterlocutor = payload;
  }
}
