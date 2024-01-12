<?php

namespace Tests\Feature\Room;

use App\Models\Interlocutor;
use App\Models\Room;
use Room\BaseRoomTest;

class InterlocutorTest extends BaseRoomTest
{
    protected function getUrlLogin(): string
    {
        return 'api/login';
    }

    public function test_create_interlocutor_for_authorized_user()
    {
        $response = $this->userAuthorizationWithHeaderAdded()
            ->postJson(self::ROUTE_INTERLOCUTOR_CREATE);

        $response->assertOk()
            ->assertJsonStructure(self::getInterlocutorStructure())
            ->assertJsonFragment(['interlocutorName' => 'Test'])
            ->assertJsonPath('user.email', '12345@gmail.com');
    }

    public function test_create_interlocutor()
    {
        $response = $this->postJson(self::ROUTE_INTERLOCUTOR_CREATE, [
                'userName' => 'Word'
            ]);

        $response->assertOk()
            ->assertJsonStructure(self::getInterlocutorStructure())
            ->assertJsonFragment(['interlocutorName' => 'Word'])
            ->assertJsonMissing(['email' => '12345@gmail.com']);
    }

    public function test_destroy_interlocutor()
    {
        $interlocutor = Interlocutor::find(1);

        $response = $this->deleteJson(self::ROUTE_INTERLOCUTOR_DESTROY . $interlocutor->code);

        $response->assertOk()
            ->assertJsonStructure(self::getInterlocutorStructure());

        $this->assertModelMissing($interlocutor);
    }

    public function test_interlocutor_show()
    {
        $interlocutor = Interlocutor::find(2);

        $response = $this->getJson(self::ROUTE_INTERLOCUTOR_SHOW . $interlocutor->code);

        $response->assertOk()
            ->assertJsonStructure(self::getInterlocutorStructure())
            ->assertJsonFragment(['interlocutorName' => $interlocutor->interlocutorName]);
    }

    public function test_get_interlocutors_room()
    {
        $room = Room::find(11);

        $response = $this->getJson(self::ROUTE_GET_INTERLOCUTORS_ROOM . $room->name);

        $response->assertOk()
            ->assertJsonCount(10);
    }
}
