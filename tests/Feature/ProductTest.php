<?php

namespace Tests\Feature;

use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    private Request $request;
    private Request $requestOther;

    private ProductController $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new Request([
            'name' => 'test',
            'description' => 'comentario del test',
            'price' => 12,
            'stock' => 2
        ]);
        $this->requestOther = new Request([
            'name' => 'test_otro',
            'description' => 'comentario del test_otro',
            'price' => 12.2,
            'stock' => 5
        ]);
        $this->controller = $this->app->make(ProductController::class);
    }

    public function test_create_product(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->controller->store($this->request)->getData();

        $this->assertEquals('test', $response->name);
    }

    public function test_list__all_products(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->controller->store($this->request)->getData();
        $this->controller->store($this->requestOther)->getData();

        $response = $this->controller->index(new Request())->getData();
        $this->assertIsArray($response->data);
        $this->assertCount(2, $response->data);
    }

    public function test_get_product_by_id(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->controller->store($this->request)->getData();

        $product = Product::create([
            'name' => 'nuevo',
            'description' => 'comentario del nuevo',
            'price' => 12.2,
            'stock' => 5
        ]);

        $response = $this->controller->show($product->id)->getData();
        $this->assertEquals('nuevo', $response->name);
    }

    public function test_update_product(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->controller->store($this->request)->getData();

        $product = Product::create([
            'name' => 'nuevo',
            'description' => 'comentario del nuevo',
            'price' => 12.2,
            'stock' => 5
        ]);

        $requestUpdate = new Request([
            'name' => 'nuevo actualizado',
            'description' => 'comentario del nuevo',
            'price' => 12.2,
            'stock' => 5
        ]);

        $response = $this->controller->update($requestUpdate, $product->id)->getData();
        $this->assertNotEquals('nuevo', $response->name);
        $this->assertEquals('nuevo actualizado', $response->name);
    }

    public function test_delete_product(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->controller->store($this->request)->getData();

        $product = Product::create([
            'name' => 'nuevo',
            'description' => 'comentario del nuevo',
            'price' => 12.2,
            'stock' => 5
        ]);

        $response = $this->controller->destroy($product->id)->getData();
        $this->assertEquals('Product deleted', $response->message);
    }
}
