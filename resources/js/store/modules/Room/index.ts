import mutations from "./mutations";
import * as actions from './actions';
import * as getters from './getters';
import {Module} from "vuex";
import {TRootState} from "../../types";
import {Interlocutor, Room} from "../../../types";

export type TRoomState = {
  room: Room | null,
  currentInterlocutor: Interlocutor | null,
  interlocutors: Interlocutor[] | null
}

const state: TRoomState = {
  room: null,
  currentInterlocutor: null,
  interlocutors: null
}

const RoomModule: Module<TRoomState, TRootState> = {
  mutations,
  actions,
  state,
  getters
}

export default RoomModule;