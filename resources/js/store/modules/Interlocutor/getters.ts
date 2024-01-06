import {TInterlocutorState} from "./index";

export const getCurrentInterlocutor = (state: TInterlocutorState) => state.currentInterlocutor;
export const getInterlocutorsRoom = (state: TInterlocutorState) => state.interlocutors;