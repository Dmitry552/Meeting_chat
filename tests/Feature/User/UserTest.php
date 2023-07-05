<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_store_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_user_store_example_2()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
