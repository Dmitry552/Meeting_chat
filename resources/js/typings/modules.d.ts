declare module "freeice";

declare module '*.svg' {
  import Vue, {VueConstructor} from 'vue';
  const content: VueConstructor<Vue>;
  export default content;
}

declare module '*.vue';

export {};

declare global {
  export interface Window {
    Echo: any;
  }
}