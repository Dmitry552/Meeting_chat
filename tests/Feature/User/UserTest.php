<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\User\Traits\UserAuthorizedTrait;

class UserTest extends BaseUserTest
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_creation()
    {
        $response = $this->postJson(
            self::ROUTE_USER_CREATE,
            [
                'name'     => 'HelloUser',
                'email'    => '12345678@gmail.com',
                'password' => '12345678',
                'password_confirmation' => '12345678'
            ]
        );

        $response->assertOk()
            ->assertJsonStructure(self::getCreationUserStructure())
            ->assertJsonFragment(self::getMessageAfterUserCreation());
    }

    public function test_user_index()
    {
        $response = $this->userAuthorizationWithHeaderAdded()
            ->getJson(self::ROUTE_USER_INDEX);

        $response->assertOk()
            ->assertJsonStructure(self::getUsersStructure())
            ->assertJsonCount(10, 'data');
    }

    public function test_display_five_users()
    {
        $response = $this->userAuthorizationWithHeaderAdded()
            ->getJson(self::ROUTE_USER_INDEX . '?limit=5');

        $response->assertOk()
            ->assertJsonStructure(self::getUsersStructure())
            ->assertJsonCount(5, 'data');
    }

    public function test_show_user()
    {
        $response = $this->userAuthorizationWithHeaderAdded()
            ->getJson(self::ROUTE_USER_SHOW . '1');

        $response->assertOk()
            ->assertJsonStructure(self::getUserStructure());
    }

    public function test_delete_user()
    {
        $user = User::find(1);

        $response = $this->userAuthorizationWithHeaderAdded()
            ->deleteJson(self::ROUTE_USER_DESTROY . '1');

        $response->assertOk()
            ->assertJsonStructure(self::getUserStructure());

        $this->assertModelMissing($user);
    }

    public function test_update_user()
    {
        $response = $this->userAuthorizationWithHeaderAdded()
            ->putJson(
                self::ROUTE_USER_DESTROY . '2',
                [
                    "name" => 'Stepan',
                    'email' => 'hello@gmail.com'
                ]
            );

        $response->assertOk()
            ->assertJsonStructure(self::getUserStructure());

        $this->assertDatabaseHas('users', [
            "name" => 'Stepan',
            'email' => 'hello@gmail.com',
        ]);;
    }
}
