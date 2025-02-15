<?php

namespace Tests\Feature\Traits;

use Illuminate\Testing\AssertableJsonString;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;
use Throwable;

trait UserAuthorizedTrait
{
    /**
     * The method returns a Json response
     *
     * @param string $email
     * @param string $password
     * @return AssertableJsonString
     * @throws Throwable
     */
    protected function authorizedUser(
        string $email = '12345@gmail.com',
        string $password = '12345678',
    ): AssertableJsonString {
        return $this->authorize($email, $password)->decodeResponseJson();
    }

    /**
     * Returns the TestCase instance with the header 'Authorization' attached
     *
     * @param string $email
     * @param string $password
     * @return TestCase
     * @throws Throwable
     */
    protected function userAuthorizationWithHeaderAdded(
        string $email = '12345@gmail.com',
        string $password = '12345678',
    ): TestCase {
        $responseData = $this->authorize($email, $password)->decodeResponseJson();

        return $this->withHeader(
            $responseData['token_type'],
            'bearer ' . $responseData['access_token']
        );
    }

    protected function getAuthUserLoginRequest(): array
    {
        return [
            'access_token',
            'token_type',
            'expires_in',
        ];
    }

    /**
     * Authorization request
     *
     * @param string $email
     * @param string $password
     * @return TestResponse
     */
    private function authorize(string $email, string $password): TestResponse
    {
        $response = $this->postJson(
            $this->getUrlLogin(),
            [
                'email' => $email,
                'password' => $password,
                'remember_me' => false
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

    abstract protected function getUrlLogin(): string;
}
