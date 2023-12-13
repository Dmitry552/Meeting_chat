import {TCustomAction} from "../../types";
import {TRoomState} from "./types";


export const joinRoom: TCustomAction<TRoomState> = ({commit}, data): Promise<void> => {
  return new Promise((resolve, reject) => {
    resolve();
  });
}