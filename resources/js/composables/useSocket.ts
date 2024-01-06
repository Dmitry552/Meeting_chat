// import socket from "../socket";
import {TActions} from "../socket/actions.js";
import {useStore} from "../store";
import {computed} from "vue";
import {Room} from "../types";

export default function useSocket() {
  const s = window.Echo;
  const store = useStore();

  // const getRoom = (data: string) => store.dispatch('getRoom', data);
  //
  // await getRoom('4f34f271-1faa-4279-a86b-6eeac04164bd');

  const room = computed<Room>(() => store.getters.getRoom);
  const listenChannel = (
    action: TActions,
    callable: Function,
    eventName: string = room.value.name,
    channelName: string = 'videoMeeting',
  ) => {
    return s.channel(channelName)
      .listen(`.${eventName}.${action.toUpperCase()}`, callable);
  }

  //TODO Все что ниже, удалить в конечном итоге!!!!!

  // const action = <T extends { room: string }>(action: TActions, data?: T): void => {
  //   data ? socket.emit(action, data) : socket.emit(action);
  // }
  //
  // const listen = (action: TActions, call: (...args: any[]) => void): void => {
  //   socket.on(action, call)
  // }

  return {
    listenChannel
  }
}
