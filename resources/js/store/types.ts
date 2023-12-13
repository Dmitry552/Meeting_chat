import {TUserState} from "./modules/User/types";
import {Action} from "vuex";
import {TRoomState} from "./modules/Room/types";
import {TAuthState} from "./modules/Auth";

export type TRootState = {
  user: TUserState,
  room: TRoomState,
  auth: TAuthState
};

export type TCustomAction<T> = Action<T, TRootState>