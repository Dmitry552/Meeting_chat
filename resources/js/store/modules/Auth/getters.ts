
import {TAuthState} from "./index";

export const getAuthToken = (state: TAuthState) => state.token;

export const getAuthUser = (state: TAuthState) => state.authUser;