
enum ACTIONS {
  ADD_PEER = 'ADD_PEER',
  REMOVE_PEER = 'REMOVE_PEER',
  ICE_CANDIDATE = 'ICE_CANDIDATE',
  SESSION_DESCRIPTION = 'SESSION_DESCRIPTION',
  MUTED = 'MUTED',
}

export default ACTIONS;

export type TActions = keyof typeof ACTIONS;
