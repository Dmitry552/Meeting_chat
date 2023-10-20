import socket from "../socket";
import ACTIONS, {TActions} from "../socket/actions.js";

export default function useSocket() {
  const action = <T extends { room: string }>(action: TActions, data?: T): void => {
    data ? socket.emit(action, data) : socket.emit(action);
  }

  const listen = (action: TActions, call: (...args: any[]) => void): void => {
    socket.on(action, call)
  }

  return {
    action,
    listen
  }
}
