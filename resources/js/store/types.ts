import {TUserState} from "./modules/User";
import {Action} from "vuex";
import {TRoomState} from "./modules/Room";
import {TAuthState} from "./modules/Auth";

export type TRootState = {
  user: TUserState,
  room: TRoomState,
  auth: TAuthState
};

export type TCustomAction<T> = Action<T, TRootState>