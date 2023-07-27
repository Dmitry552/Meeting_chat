import {io} from 'socket.io-client';

const options = {
  'force new connection': true,
  reconnect_attempt: 'infinity',
  timeout: 10000,
  transceivers: ['websocket']
}

const socket = io('http://localhost:8001', options);

export default socket;