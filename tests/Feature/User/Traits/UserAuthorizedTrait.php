<?php

namespace Tests\Feature\User\Traits;

trait UserAuthorizedTrait
{
    private function authorizedUser(string $email, string $password): string
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

        $responseData = $response->decodeResponseJson();

        return $responseData['access_token'];
    }

    abstract function getUrlLogin(): string;
}