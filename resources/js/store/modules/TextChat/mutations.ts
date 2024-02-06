import * as types from "./mutationsTextChatType";
import {Message} from "../../../types";
import {TTextChatState} from "./index";
import {store} from "../../index";

export default {
  [types.GET_MESSAGES]: (state: TTextChatState, payload: Message[]): void => {
    state.messages = payload;
  },
  [types.ADD_MESSAGE]: (state: TTextChatState, payload: Message): void => {
    state.messages!.push(payload);
  }
}

export const addNewMessage = (data: Message) => store.commit(types.ADD_MESSAGE, data);
