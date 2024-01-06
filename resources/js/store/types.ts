import {TUserState} from "./modules/User";
import {Action} from "vuex";
import {TRoomState} from "./modules/Room";
import {TAuthState} from "./modules/Auth";
import {TInterlocutorState} from "./modules/Interlocutor";

export type TRootState = {
  user: TUserState,
  room: TRoomState,
  auth: TAuthState,
  interlocutor: TInterlocutorState
  videoChat: any
};

export type TCustomAction<T> = Action<T, TRootState>