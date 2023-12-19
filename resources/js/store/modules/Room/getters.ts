import {TRoomState} from "./index";


export const getRoom = (state: TRoomState) => state.room;
export const getCurrentInterlocutor = (state: TRoomState) => state.currentInterlocutor;