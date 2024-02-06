import {TUserState} from "./modules/User";
import {Action} from "vuex";
import {TRoomState} from "./modules/Room";
import {TAuthState} from "./modules/Auth";
import {TInterlocutorState} from "./modules/Interlocutor";
import {TTextChatState} from "./modules/TextChat";
import {TGlobalState} from "./modules/Global";

export type TRootState = {
  user: TUserState,
  room: TRoomState,
  auth: TAuthState,
  interlocutor: TInterlocutorState,
  videoChat: any,
  textChat: TTextChatState,
  global: TGlobalState
};

export type TCustomAction<T> = Action<T, TRootState>