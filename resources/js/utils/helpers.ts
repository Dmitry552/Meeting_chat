import {Client} from "../types";

export function array_includes(array: any[], value: any): Client | boolean {
  for (let i: number = 0; i < array.length; i++) {
    if (array[i].name === value.name) {
      return array[i] as Client;
    }
  }

  return false;
}