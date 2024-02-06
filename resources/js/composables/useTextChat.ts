import ACTIONS from "../socket/actions";
import {computed, ref} from "vue";
import {Room, Message, Interlocutor} from "../types";
import {useStore} from "../store";
import {sendMessage} from "../store/modules/TextChat/actions";
import {TMessageContent} from "../store/modules/TextChat/types";
import {addNewMessage} from "../store/modules/TextChat/mutations";

export default function useTextChat() {
  const store = useStore();

  const clientName = ref<string | null>(null);

  const room = computed<Room>(() => store.getters.getRoom);
  const interlocutors = computed<Interlocutor[]>(() => store.getters.getInterlocutorsRoom);
  const textChannel = computed(() => window.Echo.private(`textMeeting.${room.value.name}`));

  const sendMessage = (data: TMessageContent) => store.dispatch('sendMessage', data);

  function handleSendMessage(message: string) {
    sendMessage({content: message}).then();
  }

  function handleNewMessage(message: {message: Message}) {
    console.log(message.message);
    addNewMessage(message.message);
  }

  textChannel.value
    .listenForWhisper('typing', (event) => {
      clientName.value = interlocutors.value.find((interlocutor: Interlocutor): boolean => {
        return interlocutor.code === event.interlocutor;
      })?.interlocutorName;
    })
    .listenForWhisper('noTyping', () => {
      clientName.value = null;
    })
    .listen(
      `.${ACTIONS.MESSAGE}`,
      handleNewMessage
    );

  return {
    clientName,
    textChannel,
    handleSendMessage
  }
}
