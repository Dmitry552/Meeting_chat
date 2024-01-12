<?php

namespace Tests\Feature\Room;

use App\Models\Interlocutor;
use App\Models\Room;
use Illuminate\Support\Str;
use Room\BaseRoomTest;

class RoomTest extends BaseRoomTest
{
    private Interlocutor $interlocutor;
    private Room $room;

    private function setData(): void
    {
        $this->interlocutor = Interlocutor::find(2);
        $this->room = Room::find(5);
    }

    protected function getUrlLogin(): string
    {
        return '';
    }

    public function test_create_room()
    {
        $this->setData();
        $roomName = Str::uuid();

        $response = $this->postJson(self::ROUTE_ROOM_CREATE . $this->interlocutor->id, [
            'creator' => $this->interlocutor->id,
            'name' => $roomName
        ]);

        $room = Room::where('name', $roomName)->first();

        $response->assertNoContent();

        $this->assertModelExists($room);
    }

    public function test_joining_room()
    {
        $this->setData();

        $response = $this->getJson(self::ROUTE_ADD_TO_ROOM. $this->room->name . '/' . $this->interlocutor->id);

        $_room = $this->interlocutor->room;

        $response->assertNoContent();

        $this->assertEquals($_room->id, $this->interlocutor->room_id);
    }

    public function test_room_exist()
    {
        $this->setData();

        $response = $this->getJson(self::ROUTE_CHECK_ROOM . $this->room->name);

        $response->assertOk();
        $responseData = $response->decodeResponseJson();

        $this->assertEquals($responseData->json(), 1);
    }

    public function test_room_missing()
    {
        $response = $this->getJson(self::ROUTE_CHECK_ROOM . '293d293dg289yb3d9b2d');

        $response->assertOk();

        $this->assertEquals($response->baseResponse->content(), '');
    }

    public function test_show_room()
    {
        $this->setData();

        $response = $this->getJson(self::ROUTE_ROOM_SHOW . $this->room->name);

        $response->assertOk()
            ->assertJsonStructure(self::getRoomStructure())
            ->assertJsonFragment(['name' => $this->room->name]);
    }
}
