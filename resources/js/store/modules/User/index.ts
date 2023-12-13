import mutations from "./mutations";
import * as actions from './actions';
import * as getters from './getters';
import {Module} from "vuex";
import {TRootState} from "../../types";
import {User} from "../../../types";

export type TUserState = {
  user: User | null
};

const state: TUserState  = {
  user: null
}

const UserModule: Module<TUserState, TRootState> = {
  mutations,
  actions,
  state,
  getters
}
export default UserModule;