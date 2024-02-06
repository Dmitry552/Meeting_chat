import * as types from "./mutationsGlobalType";
import {TGlobalState} from "./index";
import {store} from "../../index";

export default {
  [types.SET_THEME]: (state: TGlobalState, payload: 'light' | 'dark'): void => {
    state.theme = payload;
  }
}

export const setTheme = (data: 'light' | 'dark') => store.commit(
  types.SET_THEME,
  data
);