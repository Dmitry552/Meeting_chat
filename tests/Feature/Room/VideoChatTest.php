<?php

namespace Tests\Feature\Room;

use App\Events\VideoEvent\CurrentInterlocutorJoinedRoom;
use App\Events\VideoEvent\JoinRoom;
use App\Events\VideoEvent\LeaveRoom;
use App\Events\VideoEvent\MuteStream;
use App\Events\VideoEvent\RelayIce;
use App\Events\VideoEvent\RelaySdp;
use App\Models\Interlocutor;
use App\Models\Room;
use Illuminate\Support\Facades\Event;
use Room\BaseRoomTest;

class VideoChatTest extends BaseRoomTest
{
    private Interlocutor $interlocutor;
    private Room $room;

    public function setData(): void
    {
        $this->interlocutor = Interlocutor::find(5);
        $this->room = Room::find(1);
    }

    protected function getUrlLogin(): string
    {
        return '';
    }

    public function test_video_chat_join()
    {
        $this->setData();

        Event::fake();

        $response = $this->getJson(self::ROUTE_VIDEO_CHAT_JOINED
            . $this->room->name
            . '/'
            . $this->interlocutor->code
        );

        Event::assertDispatched(JoinRoom::class);
        Event::assertDispatched(CurrentInterlocutorJoinedRoom::class);

        $response->assertOk();
    }

    public function test_video_chat_relay_ice()
    {
        $this->setData();
        Event::fake();

        $response = $this->postJson(self::ROUTE_VIDEO_CHAT_RELAY_ICE
            . $this->room->name
            . '/'
            . $this->interlocutor->code,
            [
                'interlocutorCode' => '2389rh237hr82234f34f4f3fvef34345345',
                'iceCandidate' => 'bla-bla-bal'
            ]
        );

        Event::assertDispatched(RelayIce::class);

        $response->assertOk();
    }

    public function test_video_chat_relay_sdp()
    {
        $this->setData();
        Event::fake();

        $response = $this->postJson(self::ROUTE_VIDEO_CHAT_RELAY_SDP
            . $this->room->name
            . '/'
            . $this->interlocutor->code,
            [
                'interlocutorCode' => '2389rh237hr82234f34f4f3fvef34345345',
                'sessionDescription' => 'bla-bla-bal'
            ]
        );

        Event::assertDispatched(RelaySdp::class);

        $response->assertOk();
    }

    public function test_video_chat_mute()
    {
        $this->setData();
        Event::fake();

        $response = $this->postJson(self::ROUTE_VIDEO_CHAT_MUTE
            . $this->room->name
            . '/'
            . $this->interlocutor->code,
            [
                'interlocutorCode' => '2389rh237hr82234f34f4f3fvef34345345',
                'value' => true,
                'key' => 'video'
            ]
        );

        Event::assertDispatched(MuteStream::class);

        $response->assertOk();
    }

    public function test_video_chat_leave()
    {
        $this->setData();
        Event::fake();

        $response = $this->getJson(self::ROUTE_VIDEO_CHAT_LEAVE
            . $this->room->name
            . '/'
            . $this->interlocutor->code
        );

        Event::assertDispatched(LeaveRoom::class);

        $response->assertOk();

        $this->assertSoftDeleted($this->interlocutor);
    }
}
