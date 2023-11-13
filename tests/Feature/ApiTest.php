<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_view_user()
    {
        $response = $this->getJson('api/user');

        $response->assertStatus(200)
        ->assertJson([
            // 'created' => true,
        ]);
    }
}
