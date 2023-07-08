<?php

namespace Tests\Feature\User\Traits;

use Illuminate\Testing\TestResponse;

trait UserAuthorizedTrait
{
    private function authorizedUser(
        string $email = '12345@gmail.com',
        string $password = '12345678',
    )
    {
        return $this->authorize($email, $password)->decodeResponseJson();
    }

    private function userAuthorizationWithHeaderAdded(
        string $email = '12345@gmail.com',
        string $password = '12345678',
    )
    {
        $responseData = $this->authorize($email, $password)->decodeResponseJson();

        return $this->withHeader(
            $responseData['token_type'],
            'bearer ' . $responseData['access_token']
        );
    }

    private function authorize(string $email, string $password)
    {
        $response = $this->postJson(
            $this->getUrlLogin(),
            [
                'email' => $email,
                'password' => $password
            ]
        );

        $response->assertOk()
            ->assertJsonStructure(
                [
                    'access_token',
                    'token_type',
                    'expires_in',
                ]
            );

        return $response;
    }

    abstract function getUrlLogin(): string;
}