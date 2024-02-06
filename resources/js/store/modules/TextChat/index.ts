import {Message} from "../../../types";
import {Module} from "vuex";
import {TRootState} from "../../types";
import mutations from "./mutations";
import * as actions from "./actions";
import * as getters from "./getters";

export type TTextChatState = {
  messages: Message[] | null,
}

const state: TTextChatState = {
  messages: null,
}

const TextChatModule: Module<TTextChatState, TRootState> = {
  mutations,
  actions,
  state,
  getters
}

export default TextChatModule;