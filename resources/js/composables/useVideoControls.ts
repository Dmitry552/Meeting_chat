import {TPeerMediaElement} from "./useWebRTC";
import {Ref, ref, UnwrapRef} from "vue";
import useSocket from "./useSocket";
import ACTIONS from "../socket/actions";

export function useVideoControls(
) {
  const {action} = useSocket();
  const video = ref<MediaStream>();
  const showVideo = ref<boolean>(false);
  const showAudio = ref<boolean>(false);

  async function muteVideo(
    localMedia: Ref<MediaStream>,
    peerMedia: Ref<TPeerMediaElement>
  ): Promise<void> {
    if (!showVideo.value) {
      showVideo.value = true;
      localMedia.value!.getVideoTracks()[0].stop();
      video.value = await navigator.mediaDevices.getUserMedia({audio: true, video: false});
      peerMedia.value['LOCAL_VIDEO'].srcObject = null;
      peerMedia.value['LOCAL_VIDEO'].srcObject = video.value;

      action(ACTIONS.MUTE_VIDEO_STREAM);
    } else {
      peerMedia.value['LOCAL_VIDEO'].srcObject = null;
      video.value = await navigator.mediaDevices.getUserMedia({audio: true, video: true});
      peerMedia.value['LOCAL_VIDEO'].srcObject = video.value;
      showVideo.value = false;

      action(ACTIONS.MUTE_VIDEO_STREAM);
    }
  }

  return {
    muteVideo
  }
}
