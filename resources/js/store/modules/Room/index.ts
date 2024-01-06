import mutations from "./mutations";
import * as actions from './actions';
import * as getters from './getters';
import {Module} from "vuex";
import {TRootState} from "../../types";
import {Room} from "../../../types";

export type TRoomState = {
  room: Room | null,
}

const state: TRoomState = {
  room: null
}

const RoomModule: Module<TRoomState, TRootState> = {
  mutations,
  actions,
  state,
  getters
}

export default RoomModule;