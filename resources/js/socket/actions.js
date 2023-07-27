
const ACTIONS = {
  JOIN: 'join', //Присоединение к комнате
  LEAVE: 'leave', //Покидание комнаты
  SHARE_ROOMS: 'share-rooms', //Поделится комнатами
  ADD_PEER: 'add-peer', //Подключение нового пира (новое соединение между клиентами
  REMOVE_PEER: 'remove-peer', //Отключение нового пира (новое соединение между клиентами
  RELAY_SDP: 'relay-sdp', //Передача sdp данных (стримы, медиа данные)
  RELAY_ICE: 'relay-ice', //Передача ice кандидата
  ICE_CANDIDATE: 'ice-candidate', //Реагирование на нового кандидата
  SESSION_DESCRIPTION: 'session-description' //Когда придет новая сессия
}

export default ACTIONS;