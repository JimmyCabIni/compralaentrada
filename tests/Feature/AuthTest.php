<?php

namespace Tests\Feature;

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    private Request $request;
    private AuthController $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new Request([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'cambiame123',
        ]);

        $this->controller = $this->app->make(AuthController::class);
    }

    public function test_register_user(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->controller->register($this->request)->getData();
        $this->assertEquals('test', $response->user->name);
    }

    public function test_login_user(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->controller->register($this->request)->getData();

        $token = $this->controller->login($this->request)->getData();
        $this->assertObjectHasProperty('token', $token);
    }

    public function test_logout_user(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->controller->register($this->request)->getData();
        $responseData = $this->controller->login($this->request)->getData();

        $token = $responseData->token;
        $this->assertNotEmpty($token);


        // $response = $this->controller->logout(
        //     new Request([], [], [], [], [], ['HTTP_AUTHORIZATION' => "Bearer $token"])
        // );
        // $this->assertEquals('You are logout', $responseData->message);
    }
}
