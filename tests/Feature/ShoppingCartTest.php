<?php

namespace Tests\Feature;

use Database\Seeders\ShoppingCartSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\User;
use App\Models\ShoppingCart;
use Illuminate\Foundation\Testing\WithFaker;

class ShoppingCartTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    protected $baseURL = '/api/shopping-carts';
    protected $seeder = ShoppingCartSeeder::class;
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

        $this->withHeaders($this->headers)->post("/api/users", $user);

        $baseUser = [
            'email' => "testing@testing.com",
            'password' => 'password',
        ];

        $this->login = $this->withHeaders($this->headers)->post("/api/login", $baseUser);
    }

    /**
     * Check if the route /shopping-carts returns all shopping carts
     */
    public function testGetAllShoppingCarts(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->withHeaders($this->headers)->get($this->baseURL);

        $response->assertStatus(200)->assertJsonCount(3);
    }

    /**
     * Check if the route /shopping-carts/{id} returns a specific shopping cart
     */
    public function testGetOneShoppingCart(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $responseValid = $this->withHeaders($this->headers)->get("$this->baseURL/1");
        $responseInvalid = $this->withHeaders($this->headers)->get("$this->baseURL/100");

        $responseValid
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->hasAll(
                        'SHOPPING_CART_ID'
                    )
                    ->whereAll([
                        'SHOPPING_CART_ID' => 1,
                    ])
            );

        $responseInvalid->assertNotFound();
    }

    /**
     * Check if the route /shopping-carts can create a shopping cart
     */
    public function testCreateShoppingCart(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $shoppingCart = [
            'SHOPPING_CART_ID' => 4,
        ];

        $responseValid = $this
            ->withHeader('Authorization', 'Bearer '.$this->login['access_token'])
            ->withHeaders($this->headers)
            ->post($this->baseURL, $shoppingCart);

        $responseInvalid = $this->post($this->baseURL);

        $responseValid
            ->assertCreated()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->hasAll(
                        'SHOPPING_CART_ID'
                    )
                    ->whereAll([
                        'SHOPPING_CART_ID' => 4
                    ])
            );

        $responseInvalid->assertUnprocessable();
    }

    /**
     * Check if the route /shopping-carts/{id} can update a shopping cart
     */
    public function testUpdateShoppingCart(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $shoppingCart = [
            'SHOPPING_CART_ID' => 1,
        ];

        $responseValid = $this
            ->withHeader('Authorization', 'Bearer '.$this->login['access_token'])
            ->withHeaders($this->headers)
            ->put("$this->baseURL/1", $shoppingCart);

        $responseInvalid = $this->put("$this->baseURL/1");

        $responseValid
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->hasAll(
                        'SHOPPING_CART_ID'
                    )
                    ->whereAll([
                        'SHOPPING_CART_ID' => 1
                    ])
            );

        $responseInvalid->assertUnprocessable();
    }

    /**
     * Check if the route /shopping-carts/{id} can delete a shopping cart
     */
    public function testDeleteShoppingCart(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $responseValid = $this->withHeaders($this->headers)->delete("$this->baseURL/1");
        $responseNotFound = $this->delete("$this->baseURL/1");

        $responseValid->assertOk();
        $responseNotFound->assertNotFound();
    }
}
