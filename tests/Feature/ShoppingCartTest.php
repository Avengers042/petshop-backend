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

    protected $baseURL = '/api/carts';
    protected $seeder = ShoppingCartSeeder::class;
    protected $headers = ['Accept' => 'application/json'];
    protected $login;

    /**
     * Check if the route /carts returns all shopping carts
     */
    public function testGetAllShoppingCarts(): void
    {
        $response = $this->withHeaders($this->headers)->get($this->baseURL);
        $response->assertOk()->assertJsonCount(25);
    }

    /**
     * Check if the route /carts/{id} returns a specific shopping cart
     */
    public function testGetOneShoppingCart(): void
    {
        $responseValid = $this->withHeaders($this->headers)->get("$this->baseURL/1");
        $responseInvalid = $this->withHeaders($this->headers)->get("$this->baseURL/100");

        $responseValid
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->hasAll(
                        'shoppingCartId'
                    )
                    ->whereAll([
                        'shoppingCartId' => 1,
                    ])
            );

        $responseInvalid->assertNotFound();
    }
}
