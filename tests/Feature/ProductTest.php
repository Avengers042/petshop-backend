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
    protected $login;

    protected function setUp(): void
    {
        parent::setUp();
        $user = [
            'firstName' => $this->faker->firstName(),
            'lastName' => $this->faker->lastName(),
            'cpf' => $this->faker->cpf(false),
            'email' => "testing@testing.com",
            'birthday' => '2014-06-28',
            'password' => 'password',
            'addressId' => 1,
            'shoppingCartId' => 1
        ];

        $this->withHeaders($this->headers)->post("$this->baseURL", $user);

        $baseUser = [
            'email' => "testing@testing.com",
            'password' => 'password',
        ];

        $this->login = $this->withHeaders($this->headers)->post("/api/login", $baseUser);
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

    /**
     * Check if the route /products can create a product
     *
     * @doesNotPerformAssertions
     */
    public function testCreateProduct() : void
    {
        $product = [
            'name' => "test",
            'description' => "testdesc",
            'supplierId' => 1,
            'price' => 100,
            'imageId' => 1,
            'categoryId' => 1
        ];

        $responseValid = $this
            ->withHeader('Authorization', 'Bearer '.$this->login['access_token'])
            ->withHeaders($this->headers)
            ->post("$this->baseURL/1", $product);

        $productInvalid = [
            'description' => "",
            'supplierId' => 0,
            'price' => 0,
            'imageId' => 0,
            'categoryId' => 0
        ];

        $productNotFound = [
            'name' => "test",
            'description' => "testdesc",
            'supplierId' => 100,
            'price' => 0,
            'imageId' => 100,
            'categoryId' => 100
        ];

        $responseValid = $this->withHeaders($this->headers)->post("$this->baseURL", $product);
        $responseInvalid = $this->post("$this->baseURL", $productInvalid);

        $responseNull = $this->post("$this->baseURL");
        $responseNotFoundProduct = $this->post("$this->baseURL", $productNotFound);

        $responseValid
            ->assertCreated()
            ->assertJson(
                fn (AssertableJson $json) =>
                $json
                    ->hasAll('productId', 'name', 'description', 'supplierId', 'price', 'imageId', 'categoryId')
                    ->whereAll([
                        'name' => 'test',
                        'description' => 'testdesc',
                        'supplierId' => 1,
                        'price' => 100,
                        'imageId' => 1,
                        'categoryId' => 1
                    ])
            );

        $responseInvalid->assertUnprocessable();
        $responseNull->assertUnprocessable();
        $responseNotFoundProduct->assertServiceUnavailable();
    }

    /**
     * Check if the route /products can update a products
     *
     * @doesNotPerformAssertions
     */
    public function testUpdateProduct() : void
    {
        $product = [
            'name' => 'testing',
            'description' => 'new description',
            'supplierId' => 1,
            'price' => 0,
            'imageId' => 1,
            'categoryId' => 1
        ];

        $responseValid = $this
        ->withHeader('Authorization', 'Bearer '.$this->login['access_token'])
        ->withHeaders($this->headers)
        ->put("$this->baseURL/1", $product);

        $productInvalid = [
            'description' => "",
            'supplierId' => 0,
            'price' => 0,
            'imageId' => 0,
            'categoryId' => 0
        ];

        $responseValid = $this->withHeaders($this->headers)->put("$this->baseURL/1", $product);
        $responseInvalid = $this->put("$this->baseURL/1", $productInvalid);
        $responseNull = $this->put("$this->baseURL/1");
        $responseNotFoundProduct = $this->put("$this->baseURL/100", $product);

        Log::debug($responseValid->getContent());
        $responseValid
            ->assertOk()
            ->assertJson(
                fn (AssertableJson $json) =>
                $json
                    ->hasAll('productId', 'name', 'description', 'supplierId', 'price', 'imageId', 'categoryId')
                    ->whereAll([
                        'productId' => 1,
                        'name' => 'testing',
                        'description' => 'new description',
                        'supplierId' => 1,
                        'price' => 0,
                        'imageId' => 1,
                        'categoryId' => 1
                    ])
            );

        $responseInvalid->assertUnprocessable();
        $responseNull->assertUnprocessable();
        $responseNotFoundProduct->assertNotFound();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testDeleteProduct() : void
    {
        $responseValid = $this->withHeaders($this->headers)->delete("$this->baseURL/1");
        $responseNotFound = $this->delete("$this->baseURL/1");

        $responseValid->assertOk();
        $responseNotFound->assertNotFound();
    }
}
