export type TTranslationIceData = {
  interlocutorCode: string,
  iceCandidate: RTCIceCandidate
}

export type TTranslationSpdData = {
  interlocutorCode: string,
  sessionDescription: RTCSessionDescriptionInit
}

export type TMuteData = {
  interlocutorCode: string,
  value: boolean,
  key: 'video' | 'audio'
}