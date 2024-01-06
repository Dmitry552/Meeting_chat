import * as types from "./mutationsRoomTypes";
import {TRoomState} from "./index";
import {Room} from "../../../types";

export default {
  [types.GET_ROOM]: (state: TRoomState, payload: Room): void => {
    state.room = payload;
  }
}
