import { InjectionKey } from 'vue'
import {createStore, Store, useStore as baseUseStore} from "vuex";
import {TRootState} from "./types";
import UserModule from "./modules/User/index";
import RoomModule from "./modules/Room/index";
import AuthModule from "./modules/Auth";
import InterlocutorModule from "./modules/Interlocutor";
import VideoChatModule from "./modules/VideoChat";
import TextChatModule from "./modules/TextChat";
import GlobalModule from "./modules/Global";

export const key: InjectionKey<Store<TRootState>> = Symbol()

export const store: Store<TRootState> = createStore<TRootState>({
  modules: {
    global: GlobalModule,
    user: UserModule,
    auth: AuthModule,
    room: RoomModule,
    interlocutor: InterlocutorModule,
    videoChat: VideoChatModule,
    textChat: TextChatModule
  }
});

export function useStore () {
  return baseUseStore(key)
}