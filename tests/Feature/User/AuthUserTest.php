<?php

namespace Tests\Feature\User;

use Tests\Feature\User\Traits\UserAuthorizedTrait;

class AuthUserTest extends BaseUserTest
{
    use UserAuthorizedTrait;

    private function getUrlLogin(): string
    {
        return parent::ROUTE_USER_LOGIN;
    }

    public function test_error_for_missing_email_address()
    {
        $response = $this->postJson(
            self::ROUTE_USER_LOGIN,
            [
                'password' => '12345678'
            ]
        );

        $response->assertStatus(self::STATUS_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(self::getValidationErrorStructure())
            ->assertJsonFragment(self::getErrorEmailFieldIsRequired());
    }



    public function test_error_to_wrong_email()
    {
        $response = $this->postJson(
            parent::ROUTE_USER_LOGIN,
            [
                'email' => '12345gmail.com',
                'password' => '12345678'
            ]
        );

        $response->assertStatus(self::STATUS_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(self::getValidationErrorStructure())
            ->assertJsonFragment(self::getErrorEmailMustBeValid());
    }

    public function test_error_for_missing_password_address()
    {
        $response = $this->postJson(
            self::ROUTE_USER_LOGIN,
            [
                'email' => '12345g@mail.com'
            ]
        );

        $response->assertStatus(self::STATUS_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(self::getValidationErrorStructure())
            ->assertJsonFragment(self::getErrorPasswordFieldIsRequired());
    }

    public function test_error_to_wrong_password()
    {
        $response = $this->postJson(
            parent::ROUTE_USER_LOGIN,
            [
                'email' => '12345@gmail.com',
                'password' => 'fgkljbnfgknb'
            ]
        );

        $response->assertStatus(self::STATUS_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(self::getValidationErrorStructure())
            ->assertJsonFragment(self::getErrorPasswordMustBeValid());
    }

    public function test_user_unauthorized()
    {
        $response = $this->postJson(
            parent::ROUTE_USER_LOGIN,
            [
                'email' => '123fv45@gmail.com',
                'password' => '234ergeerg'
            ]
        );

        $response->assertStatus(self::STATUS_UNAUTHORIZED)
            ->assertJsonFragment(self::getUnauthorizedfragment());
    }

    public function test_user_login()
    {

        $response = $this->postJson(
            parent::ROUTE_USER_LOGIN,
            [
                'email' => '12345@gmail.com',
                'password' => '12345678'
            ]
        );

        $response->assertOk();
        $response->assertJsonStructure(self::getAuthUserLoginRequest());
    }

    public function test_user_logout()
    {
        $token = $this->authorizedUser('12345@gmail.com', '12345678');

        $response = $this->withHeader(
            'Authorization',
            'bearer ' . $token
        )
            ->postJson(self::ROUTE_USER_LOGOUT);

        $response->assertStatus(200)
            ->assertJsonFragment(self::getLogoutFragment());
    }

    public function test_user_refresh()
    {
        $token = $this->authorizedUser('12345@gmail.com', '12345678');

        $response = $this->withHeader(
            'Authorization',
            'bearer ' . $token
        )
            ->postJson(self::ROUTE_USER_REFRESH);

        $response->assertStatus(200);

        $newToken = $response->decodeResponseJson()['access_token'];

        $this->assertNotEquals($token, $newToken);
    }
}
