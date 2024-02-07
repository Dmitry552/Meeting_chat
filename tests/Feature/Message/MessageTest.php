<?php

namespace Tests\Feature\Message;

use App\Events\TextEvent\MakeMessage;
use App\Models\Interlocutor;
use App\Models\Message;
use App\Models\Room;
use Illuminate\Support\Facades\Event;
use Message\BaseMessageTest;

class MessageTest extends BaseMessageTest
{
    protected function getUrlLogin(): string
    {
        return 'api/login';
    }

    public function test_message_creation()
    {
        Event::fake();

        $room = Room::query()->find(10);
        $interlocutor = Interlocutor::query()->find(10);

        $response = $this->postJson(self::ROUTE_MESSAGE_CREATE
            . $room->name
            . '/'
            . $interlocutor->code,
            [
                'content' => 'Test message'
            ]
        );

        Event::assertDispatched(MakeMessage::class);

        $response->assertOk()
            ->assertJsonStructure(self::getMessageStructure())
            ->assertJsonFragment(self::getMessagesContent());
    }

    public function test_message_index()
    {
        $room = Room::query()->find(10);

        $response = $this->getJson(self::ROUTE_MESSAGE_INDEX . $room->name);

        $response->assertOk()
            ->assertJsonStructure(self::getMessagesStructure())
            ->assertJsonCount(10, 'data');
    }

    public function test_display_five_messages()
    {
        $room = Room::query()->find(10);

        $response = $this->getJson(self::ROUTE_MESSAGE_INDEX . $room->name . '?limit=5');

        $response->assertOk()
            ->assertJsonStructure(self::getMessagesStructure())
            ->assertJsonCount(5, 'data');
    }

    public function test_delete_message()
    {
        $message = Message::query()->find(200);

        $response = $this->deleteJson(self::ROUTE_MESSAGE_DESTROY . '200');

        $response->assertOk()
            ->assertJsonStructure(self::getMessageStructure());

        $this->assertSoftDeleted($message);
    }
}
