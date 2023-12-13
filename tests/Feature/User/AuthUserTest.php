<?php

namespace Tests\Feature\User;

use Tests\Feature\User\Traits\UserAuthorizedTrait;

class AuthUserTest extends BaseUserTest
{
    protected function getUrlLogin(): string
    {
        return parent::ROUTE_AUTH_LOGIN;
    }

    public function test_error_for_missing_email_address()
    {
        $response = $this->postJson(
            self::ROUTE_AUTH_LOGIN,
            [
                'password' => '12345678',
                'remember_me' => false
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
                'password' => '12345678',
                'remember_me' => false
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
                'email' => '12345g@mail.com',
                'remember_me' => false
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
                'password' => 'fgkljbnfgknb',
                'remember_me' => false
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
                'password' => '234ergeerg',
                'remember_me' => false
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
                'password' => '12345678',
                'remember_me' => false
            ]
        );

        $response->assertOk();
        $response->assertJsonStructure(self::getAuthUserLoginRequest());
    }

    public function test_user_logout()
    {
        $response = $this->userAuthorizationWithHeaderAdded()
            ->postJson(self::ROUTE_AUTH_LOGOUT);

        $response->assertStatus(200)
            ->assertJsonFragment(self::getLogoutFragment());
    }

    public function test_user_refresh_token()
    {
        $responseData = $this->authorizedUser();

        $token = $responseData['access_token'];

        $response = $this->withHeader(
            $responseData['token_type'],
            'bearer ' . $responseData['access_token']
        )->postJson(self::ROUTE_AUTH_REFRESH);

        $response->assertStatus(200);

        $netToken = $response->decodeResponseJson()['access_token'];

        $this->assertNotEquals($token, $netToken);
    }
}
