<?php

namespace Tests\Feature\User;

use Tests\Feature\User\Traits\UserAuthorizedTrait;

class AuthUserTest extends BaseUserTest
{
    public function test_error_for_missing_email_address()
    {
        $response = $this->postJson(
            self::ROUTE_AUTH_LOGIN,
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
            parent::ROUTE_AUTH_LOGIN,
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
            self::ROUTE_AUTH_LOGIN,
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
            parent::ROUTE_AUTH_LOGIN,
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
            parent::ROUTE_AUTH_LOGIN,
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
            parent::ROUTE_AUTH_LOGIN,
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
        $response = $this->userAuthorizationWithHeaderAdded()
            ->postJson(self::ROUTE_AUTH_LOGOUT);

        $response->assertOk()
            ->assertJsonFragment(self::getLogoutFragment());
    }

    public function test_user_refresh()
    {
        $responseData = $this->authorizedUser();

        $token = $responseData['access_token'];

        $response = $this->withHeader(
            $responseData['token_type'],
            'bearer ' . $responseData['access_token']
        )->postJson(self::ROUTE_AUTH_REFRESH);

        $response->assertOk();

        $netToken = $response->decodeResponseJson()['access_token'];

        $this->assertNotEquals($token, $netToken);
    }

    public function test_user_me()
    {
        $responseData = $this->authorizedUser();

        $token = $responseData['access_token'];

        $response = $this->withHeader(
            $responseData['token_type'],
            'bearer ' . $responseData['access_token']
        )->getJson(self::ROUTE_AUTH_SHOW_ME);

        $response->assertOk()
            ->assertJsonStructure(self::getUserStructure());
    }
}
