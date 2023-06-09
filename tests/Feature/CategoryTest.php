<?php

namespace Tests\Feature;

use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;

class CategoryTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    protected $baseURL = '/api/categories';
    protected $seeder = CategorySeeder::class;
    protected $headers = ['Accept' => 'application/json'];

    /**
     * Check if the route /categories return all 25 categories registers
     */
    public function testGetAllCategories() : void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->withHeaders($this->headers)->get($this->baseURL);

        $response->assertStatus(200)->assertJsonCount(3);
    }

    /**
     * Check if the route /categories return one value
     */
    public function testGetOneCategory() : void
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
                        'categoryId',
                        'name',
                    )
                    ->whereAll([
                        'categoryId' => 1,
                    ])
            );

        $responseInvalid->assertNotFound();
    }
}