<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;

class UserTest extends BaseUserTest
{
    protected function getUrlLogin(): string
    {
        return parent::ROUTE_AUTH_LOGIN;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_creation()
    {
        Event::fake();

        $response = $this->postJson(
            self::ROUTE_USER_CREATE,
            [
                'email'    => '12345678@gmail.com',
                'password' => '12345678',
                'password_confirmation' => '12345678',
                'remember_me' => false
            ]
        );

        Event::assertDispatched(Registered::class);

        $response->assertOk()
            ->assertJsonStructure(self::getCreationUserStructure())
            ->assertJsonFragment(self::getMessageAfterUserCreation());
    }

    public function test_user_error_index()
    {
        $response = $this->userAuthorizationWithHeaderAdded()
            ->getJson(self::ROUTE_USER_INDEX);

        $response->assertStatus(self::STATUS_FORBIDDEN)
            ->assertJsonFragment(self::getActionUnauthorizedFragment());
    }

    public function test_user_index()
    {
        $response = $this->userAuthorizationWithHeaderAdded('admin@gmail.com', 'admin1')
            ->getJson(self::ROUTE_USER_INDEX);

        $response->assertOk()
            ->assertJsonStructure(self::getUsersStructure())
            ->assertJsonCount(10, 'data');
    }

    public function test_display_five_users()
    {
        $response = $this->userAuthorizationWithHeaderAdded('admin@gmail.com', 'admin1')
            ->getJson(self::ROUTE_USER_INDEX . '?limit=5');

        $response->assertOk()
            ->assertJsonStructure(self::getUsersStructure())
            ->assertJsonCount(5, 'data');
    }

    public function test_show_user()
    {
        $response = $this->userAuthorizationWithHeaderAdded('admin@gmail.com', 'admin1')
            ->getJson(self::ROUTE_USER_SHOW . '1');

        $response->assertOk()
            ->assertJsonStructure(self::getUserStructure());
    }

    public function test_show_user_owner()
    {
        $response = $this->userAuthorizationWithHeaderAdded()
            ->getJson(self::ROUTE_USER_SHOW . '11');

        $response->assertOk()
            ->assertJsonStructure(self::getUserStructure());
    }

    public function test_delete_user()
    {
        $user = User::find(1);

        $response = $this->userAuthorizationWithHeaderAdded('admin@gmail.com', 'admin1')
            ->deleteJson(self::ROUTE_USER_DESTROY . '1');

        $response->assertOk()
            ->assertJsonStructure(self::getUserStructure());

        $this->assertModelMissing($user);
    }

    public function test_update_user()
    {
        $response = $this->userAuthorizationWithHeaderAdded()
            ->putJson(
                self::ROUTE_USER_UPDATE . '11',
                [
                    "firstName" => 'Stepan',
                    'email' => 'hello@gmail.com'
                ]
            );

        $response->assertOk()
            ->assertJsonStructure(self::getUserStructure());

        $this->assertDatabaseHas('users', [
            "firstName" => 'Stepan',
            'email' => 'hello@gmail.com',
        ]);;
    }

    public function test_upload_password()
    {
        $oldPassword = User::query()->find(11)->password;

        $response = $this->userAuthorizationWithHeaderAdded()
            ->postJson(
                self::ROUTE_USER_UPLOAD_PASSWORD . '11',
                [
                    'oldPassword' => '12345678',
                    'password' => '123456789',
                    'password_confirmation' => '123456789'
                ]
            );

        $newPassword = User::query()->find(11)->password;

        $response->assertOk();
        $this->assertNotEquals($oldPassword, $newPassword);
    }
}
