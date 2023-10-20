import mutations from "./mutations";
import * as actions from './actions';
import * as getters from './getters';
import {Module} from "vuex";
import {TUserState} from "./types";
import {TRootState} from "../../types";

const state = {}

const UserModule: Module<TUserState, TRootState> = {
  mutations,
  actions,
  state,
  getters
}
export default UserModule;