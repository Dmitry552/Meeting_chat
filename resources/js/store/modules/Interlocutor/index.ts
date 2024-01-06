import {Interlocutor} from "../../../types";
import {Module} from "vuex";
import {TRootState} from "../../types";
import mutations from "./mutations";
import * as actions from "./actions";
import * as getters from "./getters";

export type TInterlocutorState = {
  currentInterlocutor: Interlocutor | null,
  interlocutors: Interlocutor[] | null,
}

const state: TInterlocutorState = {
  currentInterlocutor: null,
  interlocutors: null
}

const InterlocutorModule: Module<TInterlocutorState, TRootState> = {
  mutations,
  actions,
  state,
  getters
}

export default InterlocutorModule;