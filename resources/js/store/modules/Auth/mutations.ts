import * as types from './mutationsAuthTypes';
import {User} from "../../../types";
import {TAuthState} from "./index";

export default {
  [types.SAVE_AUTH_TOKEN]: (state: TAuthState, payload: {token: string}): void => {
    state.token = payload.token;
    console.log(state);
  },
  [types.SAVE_AUTH_USER]: (state: TAuthState, payload: {authUser: User}): void => {
    state.authUser = payload.authUser;
  },
  [types.REMOVE_AUTH_TOKEN]: (state: TAuthState): void => {
    state.token = '';
  },
  [types.REMOVE_AUTH_USER]: (state: TAuthState): void => {
    state.authUser = null;
  }
}