<?php

namespace App\Http\Controllers;

use App\Events\VideoEvent\CurrentInterlocutorJoinedRoom;
use App\Events\VideoEvent\JoinRoom;
use App\Events\VideoEvent\LeaveRoom;
use App\Events\VideoEvent\MuteStream;
use App\Events\VideoEvent\RelayIce;
use App\Events\VideoEvent\RelaySdp;
use App\Http\Requests\VideoChat\MuteRequest;
use App\Http\Requests\VideoChat\RelayIceRequest;
use App\Http\Requests\VideoChat\RelaySdpRequest;
use App\Http\Services\InterlocutorService;
use App\Models\Interlocutor;
use App\Models\Room;

class VideoChatController extends Controller
{
    private InterlocutorService $interlocutorService;

    public function __construct(InterlocutorService $interlocutorService)
    {
        $this->interlocutorService = $interlocutorService;
    }

    /**
     *
     * @param Room $room
     * @param Interlocutor $interlocutor
     * @return void
     */
    public function join(Room $room, Interlocutor $interlocutor)
    {
        $room->interlocutors->each(function ($_interlocutor) use ($room, $interlocutor) {
            event(new JoinRoom(
                $room->name,
                $_interlocutor->code,
                [
                    'interlocutorCode' => $interlocutor->code,
                    'createOffer' => false
                ]
            ));

            event(new CurrentInterlocutorJoinedRoom(
                $room->name,
                $interlocutor->code,
                [
                    'interlocutorCode' => $_interlocutor->code,
                    'createOffer' => true
                ]
            ));
        });
    }

    /**
     *
     * @param Room $room
     * @param Interlocutor $interlocutor
     * @return void
     */
    public function leave(Room $room, Interlocutor $interlocutor): void
    {
        event(new LeaveRoom(
            $room->name,
            [
                'interlocutorCode' => $interlocutor->code,
            ]
        ));

        $this->interlocutorService->delete($interlocutor);
    }

    /**
     *
     * @param RelayIceRequest $request
     * @param Room $room
     * @param Interlocutor $interlocutor
     * @return void
     */
    public function relayIce(RelayIceRequest $request, Room $room, Interlocutor $interlocutor): void
    {
        $data = $request->all();

        event(new RelayIce(
            $room->name,
            $data['interlocutorCode'],
            [
                'interlocutorCode' => $interlocutor->code,
                'iceCandidate' => $data['iceCandidate']
            ]
        ));
    }

    /**
     *
     * @param RelaySdpRequest $request
     * @param Room $room
     * @param Interlocutor $interlocutor
     * @return void
     */
    public function relaySdp(RelaySdpRequest $request, Room $room, Interlocutor $interlocutor): void
    {
        $data = $request->all();

        event(new RelaySdp(
            $room->name,
            $data['interlocutorCode'],
            [
                'interlocutorCode' => $interlocutor->code,
                'sessionDescription' => $data['sessionDescription']
            ]
        ));
    }

    /**
     *
     * @param MuteRequest $request
     * @param Room $room
     * @param Interlocutor $interlocutor
     * @return void
     */
    public function mute(MuteRequest $request, Room $room, Interlocutor $interlocutor): void
    {
        $data = $request->all();

        event(new MuteStream(
            $room->name,
            [
                'interlocutorCode' => $interlocutor->code,
                'value' => $data['value'],
                'key' => $data['key']
            ]
        ));
    }
}
