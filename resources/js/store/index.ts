import { InjectionKey } from 'vue'
import {createStore, Store, useStore as baseUseStore} from "vuex";
import {TRootState} from "./types";
import UserModule from "./modules/User/index";
import RoomModule from "./modules/Room/index";
import AuthModule from "./modules/Auth";

export const key: InjectionKey<Store<TRootState>> = Symbol()

export const store: Store<TRootState> = createStore<TRootState>({
  modules: {
    user: UserModule,
    auth: AuthModule
  }
});

export function useStore () {
  return baseUseStore(key)
}