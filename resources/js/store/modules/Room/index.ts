import mutations from "./mutations";
import * as actions from './actions';
import * as getters from './getters';
import {Module} from "vuex";
import {TRoomState} from "./types";
import {TRootState} from "../../types";

const state = {

}

const RoomModule: Module<TRoomState, TRootState> = {
  mutations,
  actions,
  state,
  getters
}

export default RoomModule;