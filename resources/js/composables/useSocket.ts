import Echo from "laravel-echo";

export default function useSocket(interlocutorCode: string) {

  window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    auth: {
      headers: {
        'InterlocutorCode': interlocutorCode
      }
    },
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
  });
}
