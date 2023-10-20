import {createStore, ModuleTree, StoreOptions} from "vuex";
import {Store} from 'vuex';
import modules from "./modules/index";
import {TRootState} from "./types";
import UserModule from "./modules/User/index";

const options: StoreOptions<TRootState> = {
  modules: {
    UserModule
  }
}

const store: Store<TRootState> = createStore(options);

export default store;