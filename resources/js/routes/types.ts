
export enum LayoutsName {
  LOGIN = 'login',
  MAIN = 'main',
  BLANK = 'blank'
}

type TLowercaseLayoutsName<T> = {
  [P in keyof T as Lowercase<string & P>]: string
}

export type TLayoutsName = keyof TLowercaseLayoutsName<typeof LayoutsName>