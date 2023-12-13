import * as types from './mutationsUserTypes';
import {User} from "../../../types";
import {TUserState} from "./index";

export default {
  [types.GET_USER]: (state: TUserState, payload: User): void => {
    state.user = payload;
  }
}