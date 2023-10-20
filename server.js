/**
 * Временная заглушка сигнального сервера
 */

import express from 'express';
import { createServer  } from 'http';
import { Server } from 'socket.io';
import _ACTIONS from './_actions.js';
import {version, validate} from "uuid";

const app = express();
const httpServer = createServer(app);
const io = new Server(httpServer, {
  cors: {
    origin: ["http://localhost:8000", "https://f794-5-180-128-165.ngrok-free.app"],
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
  io.emit(_ACTIONS.SHARE_ROOMS, {
    rooms: getClientRooms()
  })
}

io.on('connection', (socket) => {
  console.log('Socket connected!');
  shareRoomsInfo(); //При новом подключении шарим инфу по всем комнатам

  socket.on(_ACTIONS.JOIN, (config) => {
    const {room: roomID} = config;
    const {rooms: joinedRooms} = socket; //комнаты к которым мы уже подключены

    if (Array.from(joinedRooms).includes(roomID)) {
      return console.warn(`Already joined to ${roomID}`)
    }

    const clients = Array.from(io.sockets.adapter.rooms.get(roomID) || []);

    clients.forEach((clientID) => {
      console.log(clientID);
      io.to(clientID).emit(_ACTIONS.ADD_PEER, {
        peerID: socket.id,
        createOffer: false
      })

      socket.emit(_ACTIONS.ADD_PEER, {
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
        io.to(clientID).emit(_ACTIONS.REMOVE_PEER, {
          peerID: socket.id
        })

        socket.emit(_ACTIONS.REMOVE_PEER, {
          peerID: clientID
        });
      });

      socket.leave(roomID);

      shareRoomsInfo();
    });
  }

  socket.on(_ACTIONS.LEAVE, leaveRoom);
  socket.on('disconnecting', leaveRoom);

  socket.on(_ACTIONS.RELAY_SDP, ({room: peerID, sessionDescription}) => {
    io.to(peerID).emit(_ACTIONS.SESSION_DESCRIPTION, {
      peerID: socket.id,
      sessionDescription
    })
  });

  socket.on(_ACTIONS.RELAY_ICE, ({room: peerID, iceCandidate}) => {
    io.to(peerID).emit(_ACTIONS.ICE_CANDIDATE, {
      peerID: socket.id,
      iceCandidate
    })
  });

  socket.on(_ACTIONS.MUTE_VIDEO_STREAM, () => {
    const {rooms} = socket;
    Array.from(rooms).forEach((roomID) => {
      const clients = Array.from(io.sockets.adapter.rooms.get(roomID) || []);

      clients.forEach((clientID) => {
        if (clientID !== socket.id) {
          io.to(clientID).emit(_ACTIONS.MUTED_VIDEO_STREAM, {
            peerID: socket.id,
            a: 'my'
          })
        }
      });
    });
  })
})

httpServer.listen(PORT, () => {
  console.log(`Server started on port: ${PORT}`);
})