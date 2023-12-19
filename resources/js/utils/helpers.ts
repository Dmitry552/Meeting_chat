import {Client, NoReadonly, TDevice} from "../types";
import swal from "sweetalert";

type TDeviceKind = {
  [key: string]: string
}

export type TCountryCallingCodes = {
  name: string,
  code: string,
  codeNumber: string
}

const DeviceKind: TDeviceKind = {
  videoinput: 'camera',
  audioinput: 'microphone',
  audiooutput: 'speaker'
}

export function errorHandler(err: any, $callback?: Function) {
  if (err.data.error) {
    console.warn('Login', err.data.error);
    swal({
      title: "Ops!",
      text: err.data.error,
      icon: "warning",
    })
  } else if (err.data.errors) {
    console.error('Login', err.data.errors);
    if ($callback) {
      for (const error in err.data.errors) {
        $callback(error, err.data.errors[error][0]);
        swal({
          title: error,
          text: err.data.errors[error][0],
          icon: "warning",
        })
      }
    }
  } else if (err.data.message) {
    swal({
      title: "Ops!",
      text: err.data.message,
      icon: "warning",
    })
  } else {
    swal({
      title: "Ops!",
      text: err.statusText,
      icon: "error",
    })
  }
}

export function getFilteredDevices(array: MediaDeviceInfo[], filter: string): TDevice[] {
  const countDevice: number = 1;
  let newArray: TDevice[]  = [];
  for (let i: number = 0; i < array.length; i++) {

    if (array[i].kind !== filter) continue;

    newArray.push({
      deviceId: array[i].deviceId,
      groupId: array[i].groupId,
      kind: array[i].kind,
      label: array[i].label || `${DeviceKind[filter]} ${countDevice}`,
    });
  }

  return newArray;
}

export function isValidUrl(url: string): boolean
{
  const objRE = /^(?:(?:https?):\/\/(?:[a-z0-9_-]{1,32}(?::[a-z0-9_-]{1,32})?@)?)?(?:(?:[a-z0-9-]{1,128}\.)+(?:com|net|org|mil|edu|arpa|ru|gov|biz|info|aero|inc|name|[a-z]{2})|(?!0)(?:(?!0[^.]|255)[0-9]{1,3}\.){3}(?!0|255)[0-9]{1,3})(?:\/[a-z0-9.,_@%&?+=\~\/-]*)?(?:#[^ \'\"&<>]*)?$/i;

  return objRE.test(url);
}
