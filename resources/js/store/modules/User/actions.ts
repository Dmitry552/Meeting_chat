
import {TCustomAction} from "../../types";
import {TUserState} from "./types";

export const defaultAction: TCustomAction<TUserState> = ({commit}, data): Promise<void> => {
 return new Promise((resolve, reject) => {
  resolve()
 });
}