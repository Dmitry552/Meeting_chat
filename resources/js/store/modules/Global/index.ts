import {Module} from "vuex";
import {TRootState} from "../../types";
import mutations from "./mutations";
import * as getters from "./getters";

export type TGlobalState = {
  theme: 'light' | 'dark',
}

const state: TGlobalState = {
  theme: 'light',
}

const GlobalModule: Module<TGlobalState, TRootState> = {
  mutations,
  state,
  getters
}

export default GlobalModule;