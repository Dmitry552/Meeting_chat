import {isValidUrl} from "../utils/helpers";
import swal from "sweetalert";
import {User} from "../types";
import {useI18n} from "vue-i18n";

export interface IRoomValidation {
  checkingRoomLink: (roomLink: string) => Promise<string>,
  checkUserName: (authUser: User) => Promise<{userName: string, stopIndicator: boolean}>
}

export default function useRoomValidation(): IRoomValidation {
  const {t} = useI18n();

  const checkingRoomLink = async (roomLink): Promise<string> => {
    let path: string = '';

    if (!isValidUrl(roomLink)) return `/room/${roomLink}`;

    if (!roomLink.startsWith(`${import.meta.env.VITE_APP_URL}/room/`)) {
      await swal( {
        title: "Ops!",
        text: t("errors.home.url"),
        icon: "warning",
      });

      return path;
    }

    const url: URL = new URL(roomLink);

    if (!url.pathname.split('/')[2]) {
      await swal( {
        title: "Ops!",
        text: t("errors.home.param"),
        icon: "warning",
      });

      return path;
    }

    path = url.pathname;

    return path
  }

  const checkUserName = async (authUser: User): Promise<{userName: string, stopIndicator: boolean}> => {
    let stopIndicator: boolean = false;
    let userName: string = '';

    if (!authUser) {
      userName = await swal( {
        content: "input",
        title: "Ops!",
        text: t("errors.home['missing userName']"),
        icon: "warning",
      })

      if (!userName) {
        stopIndicator = await swal({
          title: "Ops!",
          text: t("errors.home.noUserName"),
          icon: "warning",
        });
      }
    }

    return {userName, stopIndicator};
  }

  return {
    checkingRoomLink,
    checkUserName
  }
}
