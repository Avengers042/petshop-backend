<?php

namespace Tests\Feature;

use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;
    protected $baseURL = '/api/categories';
    protected $seeder = CategorySeeder::class;
    protected $headers = ['Accept' => 'application/json'];

    /**
     * Check if the route /categories return all 25 categories registers
     */
    public function testGetAllCategories() : void
    {
        $response = $this->withHeaders($this->headers)->get("$this->baseURL");

        $response->assertStatus(200)->assertJsonCount(25);
    }

    /**
     * Check if the route /categories return one value
     */
    public function testGetOneCategory() : void
    {
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
     */
    public function testCreateCategory() : void
    {
        $category = [
            'name' => 'Dog',
        ];

        $categoryInvalid = [
            'name' => 1,
        ];

        $responseValid = $this->withHeaders($this->headers)->post("$this->baseURL", $category);
        $responseInvalid = $this->post("$this->baseURL", $categoryInvalid);
        $responseNull = $this->post("$this->baseURL");

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
     */
    public function testUpdateCategory() : void
    {
        $category = [
            'name' => 'Cat',
        ];

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
     */
    public function testDeleteCategory() : void
    {
        $responseValid = $this->withHeaders($this->headers)->delete("$this->baseURL/1");
        $responseNotFoundProduct = $this->delete("$this->baseURL/1");

        $responseValid->assertOk();
        $responseNotFoundProduct->assertNotFound();
    }
}