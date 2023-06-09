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
     * Check if the route /categories return all 25 categories registers
     */
    public function testGetAllCategories(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->withHeaders($this->headers)->get($this->baseURL);

        $response->assertStatus(200)->assertJsonCount(3);
    }

    /**
     * Check if the route /categories return one value
     */
    public function testGetOneCategory(): void
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

    /**
     * Check if the route /categories can create a category
     *
     * @doesNotPerformAssertions
     */
    public function testCreateCategory(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $category = [
            'name' => 'Dog',
        ];

        $responseValid = $this
            ->withHeader('Authorization', 'Bearer '.$this->login['access_token'])
            ->withHeaders($this->headers)
            ->post("$this->baseURL/1", $category);

        $categoryInvalid = [
            'name' => 1,
        ];

        $responseValid = $this->withHeaders($this->headers)->post($this->baseURL, $category);
        $responseInvalid = $this->post($this->baseURL, $categoryInvalid);
        $responseNull = $this->post($this->baseURL);

        $responseValid
            ->assertCreated()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->hasAll(
                        'categoryId',
                        'name',
                    )
                    ->whereAll([
                        'name' => 'Dog'
                    ])
            );

        $responseInvalid->assertUnprocessable();
        $responseNull->assertUnprocessable();
    }

    /**
     * Check if the route /categories can update a category
     *
     *@doesNotPerformAssertions
     */
    public function testUpdateCategory(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $category = [
            'name' => 'Cat',
        ];

        $responseValid = $this
            ->withHeader('Authorization', 'Bearer '.$this->login['access_token'])
            ->withHeaders($this->headers)
            ->put("$this->baseURL/1", $category);

        $categoryInvalid = [
            'name' => 1,
        ];

        $responseValid = $this->withHeaders($this->headers)->put("$this->baseURL/1", $category);
        $responseInvalid = $this->put("$this->baseURL/1", $categoryInvalid);
        $responseNull = $this->put("$this->baseURL/1");
        $responseNotFoundProduct = $this->put("$this->baseURL/100", $category);

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
                        'name' => 'Cat'
                    ])
            );

        $responseInvalid->assertUnprocessable();
        $responseNull->assertUnprocessable();
        $responseNotFoundProduct->assertNotFound();
    }

    /**
     * Check if the route /categories can delete a category
     *
     * @doesNotPerformAssertions
     */
    public function testDeleteCategory(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $responseValid = $this->withHeaders($this->headers)->delete("$this->baseURL/1");
        $responseNotFoundProduct = $this->delete("$this->baseURL/1");

        $responseValid->assertOk();
        $responseNotFoundProduct->assertNotFound();
    }
}
