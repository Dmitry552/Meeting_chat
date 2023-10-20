export type User = {
  id: number,
  name: string
  email_verified: string
  created_at: string,
  updated_at: string
};

export type ControlStream = {
  showAudio: boolean,
  showVideo: boolean,
}

export type Client = {
  user?: User,
  control: ControlStream,
  name: string,
} | null

export type Clients = Client[];



