/**
 * Временная заглушка сигнального сервера
 */

import express from 'express';
import { createServer  } from 'http';
import { Server } from 'socket.io';
import ACTIONS from './resources/js/socket/actions.js';
import {version, validate} from "uuid";

const app = express();
const httpServer = createServer(app);
const io = new Server(httpServer, {
  cors: {
    origin: "http://localhost:8000",
    credentials: true
  }
});
const PORT = 8001;

//Взять все номера комнат
function getClientRooms() {
  const {rooms} = io.sockets.adapter;

  return Array.from(rooms.keys())
    .filter((roomID) => validate(roomID) && version(roomID) === 4);
}

//При добавлении новой комнаты всем сокетам отправить об этом информацию
function shareRoomsInfo() {
  io.emit(ACTIONS.SHARE_ROOMS, {
    rooms: getClientRooms()
  })
}

io.on('connection', (socket) => {
  console.log('Socket connected!');
  shareRoomsInfo(); //При новом подключении шарим инфу по всем комнатам

  socket.on(ACTIONS.JOIN, (config) => {
    const {room: roomID} = config;
    const {rooms: joinedRooms} = socket; //комнаты к которым мы уже подключены

    if (Array.from(joinedRooms).includes(roomID)) {
      return console.warn(`Already joined to ${roomID}`)
    }

    const clients = Array.from(io.sockets.adapter.rooms.get(roomID) || []);

    clients.forEach((clientID) => {
      io.to(clientID).emit(ACTIONS.ADD_PEER, {
        peerID: socket.id,
        createOffer: false
      })

      socket.emit(ACTIONS.ADD_PEER, {
        peerID: clientID,
        createOffer: true
      })
    })

    socket.join(roomID);

    shareRoomsInfo();
  })

  function leaveRoom() {
    const {rooms} = socket;
    Array.from(rooms).forEach((roomID) => {
      const clients = Array.from(io.sockets.adapter.rooms.get(roomID) || []);

      clients.forEach((clientID) => {
        io.to(clientID).emit(ACTIONS.REMOVE_PEER, {
          peerID: socket.id
        })

        socket.emit(ACTIONS.REMOVE_PEER, {
          peerID: clientID
        });
      });

      socket.leave(roomID);

      shareRoomsInfo();
    });
  }

  socket.on(ACTIONS.LEAVE, leaveRoom);
  socket.on('disconnecting', leaveRoom);

  socket.on(ACTIONS.RELAY_SDP, ({peerID, sessionDescription}) => {
    io.to(peerID).emit(ACTIONS.SESSION_DESCRIPTION, {
      peerID: socket.id,
      sessionDescription
    })
  });

  socket.on(ACTIONS.RELAY_ICE, ({peerID, iceCandidate}) => {
    io.to(peerID).emit(ACTIONS.ICE_CANDIDATE, {
      peerID: socket.id,
      iceCandidate
    })
  });
})

httpServer.listen(PORT, () => {
  console.log(`Server started on port: ${PORT}`);
})