
enum ACTIONS {
  JOIN = 'join', //Присоединение к комнате
  LEAVE = 'leave', //Покидание комнаты
  SHARE_ROOMS = 'share_rooms', //Поделится комнатами
  ADD_PEER = 'add_peer', //Подключение нового пира (новое соединение между клиентами
  REMOVE_PEER = 'remove_peer', //Отключение нового пира (новое соединение между клиентами
  RELAY_SDP = 'relay_sdp', //Передача sdp данных (стримы, медиа данные)
  RELAY_ICE = 'relay_ice', //Передача ice кандидата
  ICE_CANDIDATE = 'ice_candidate', //Реагирование на нового кандидата
  SESSION_DESCRIPTION = 'session_description', //Когда придет новая сессия
  MUTE_VIDEO_STREAM = 'mute_video_stream', //Отключит поток видео
  MUTED_VIDEO_STREAM = 'muted_video_stream', //Обновить у всех свой поток без видео
  MUTE = 'mute',
  MUTED = 'muted'
}
export default ACTIONS;

type TLowercaseActions<T> = {
  [P in keyof T as Lowercase<string & P>]: string
}

export type TActions = keyof TLowercaseActions<typeof ACTIONS>;
