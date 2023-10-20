import UserModule from './User/index';
import {ModuleTree} from "vuex";
import {TRootState} from "../types";

const modules: ModuleTree<TRootState> = {
  UserModule
}
export default modules;