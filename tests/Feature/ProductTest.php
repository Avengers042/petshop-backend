<?php

namespace tests\Feature\ProductTest;

use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use DatabaseMigrations;
    protected $baseURL = '/api/products';
    protected $seeder = CategorySeeder::class;
    protected $headers = ['Accept' => 'application/json'];

    protected function setUp(): void
    {
        parent::setUp();
        (new ProductSeeder)->run();
    }

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
