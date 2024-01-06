import {Module} from "vuex";
import {TRootState} from "../../types";
import * as actions from "./actions";

const VideoChatModule: Module<any, TRootState> = {
  actions,
}

export default VideoChatModule;