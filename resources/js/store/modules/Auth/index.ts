import mutations from "./mutations";
import * as actions from "./actions";
import * as getters from "./getters";
import {User} from "../../../types";
import {Module} from "vuex";
import {TRootState} from "../../types";

export type TAuthState = {
  token: string,
  authUser?: User | null

}

const state: TAuthState = {
  token: localStorage.getItem('token') || '',
  authUser: null
};

const AuthModule: Module<TAuthState, TRootState> = {
  state,
  mutations,
  actions,
  getters
}

export default AuthModule;