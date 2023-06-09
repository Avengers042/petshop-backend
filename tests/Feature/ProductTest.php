<?php

namespace tests\Feature\ProductTest;

use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use DatabaseMigrations, WithFaker;
    protected $baseURL = '/api/products';
    protected $seeder = ProductSeeder::class;
    protected $headers = ['Accept' => 'application/json'];

    /**
     * Check if the route /products return all 25 products registers
     */
    public function testGetAllProducts() : void
    {
        $response = $this->withHeaders($this->headers)->get("$this->baseURL");
        $response->assertStatus(200)->assertJsonCount(25);
    }

    /**
     * Check if the route /products return one value
     */
    public function testGetOneProduct() : void
    {
        $responseValid = $this->withHeaders($this->headers)->get("$this->baseURL/1");
        $responseInvalid = $this->withHeaders($this->headers)->get("$this->baseURL/100");

        $responseValid
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                ->hasAll('productId', 'name', 'description', 'supplierId', 'price', 'imageId', 'categoryId')
                ->where('productId', 1)
            );

        $responseInvalid->assertNotFound();
    }
}
