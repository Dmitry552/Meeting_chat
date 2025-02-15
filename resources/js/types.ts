export type User = {
  id: number,
  firstName: string,
  lastName: string,
  gender: TGenderUser,
  phone: string,
  currentAddress: string,
  permanantAddress: string,
  birthday: string | Date,
  avatarPath: string,
  email: string,
  email_verified: string,
  roles: Role[],
  created_at: string,
  updated_at: string
};

export type Role = 'user' | 'admin' | 'super-admin';

export type Interlocutor = {
  id: number,
  interlocutorName: string,
  code: string,
  user: User,
  control?: ControlStream,
  mediaStream?: MediaStream,
  peerMediaElement?: HTMLVideoElement,
  peerConnection?: RTCPeerConnection
  created_at: string,
  updated_at: string,
}

export type Room = {
  id: number,
  name: string,
  creator: number,
  created_at: string,
  updated_at: string
}

export type ControlStream = {
  showAudio: boolean,
  showVideo: boolean,
}

export type Client = {
  user?: User,
  control: ControlStream,
  name: string,
} | null

export type Message = {
  id: number,
  interlocutor: Interlocutor | null,
  content: string,
  created_at: string,
  updated_at: string
}

export type Clients = Client[];

export type TDevice = NoReadonly<Omit<MediaDeviceInfo, 'toJSON'>>;

export type TGenderUser = 'Female' | 'Male' | 'Unknown animal';

// Custom utility types

export type NoReadonly<T> = {
  -readonly [P in keyof T]: T[P]
}



