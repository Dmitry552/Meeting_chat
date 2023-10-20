import {TUserState} from "./modules/User/types";
import {Action, ActionTree, GetterTree, ModuleTree, MutationTree, Plugin, StoreOptions} from "vuex";

export type TRootState = TUserState;

export type TCustomAction<T> = Action<T, TRootState>