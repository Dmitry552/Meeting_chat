<?php

namespace App\Http\Controllers;

use App\Events\VideoEvent\JoinRoom;
use App\Events\VideoEvent\LeaveRoom;
use App\Events\VideoEvent\MuteStream;
use App\Events\VideoEvent\RelayIce;
use App\Events\VideoEvent\RelaySdp;
use App\Http\Requests\VideoChat\MuteRequest;
use App\Http\Requests\VideoChat\RelayIceRequest;
use App\Http\Requests\VideoChat\RelaySdpRequest;
use App\Models\Interlocutor;
use App\Models\Room;
use Illuminate\Http\Request;

class VideoChatController extends Controller
{
    public function __construct()
    {
    }

    /**
     *
     * @param Room $room
     * @param Interlocutor $interlocutor
     * @return void
     */
    public function join(Room $room, Interlocutor $interlocutor): void
    {
        event(new JoinRoom(
            $room->name,
            [
                'interlocutorCode' => $interlocutor->code,
                'createOffer' => true
            ]
        ));
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
