<?php

namespace Tests\Feature;

use Database\Seeders\ImageSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ImageTest extends TestCase
{
    use DatabaseMigrations, WithFaker;
    protected $baseURL = '/api/images';
    protected $seeder = ImageSeeder::class;
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

    public function testGetAllImages(): void
    {
        $response = $this->withHeaders($this->headers)->get("$this->baseURL");

        $response->assertStatus(200)->assertJsonCount(25);
    }

    public function testGetOneImage(): void
    {
        $responseValid = $this->withHeaders($this->headers)->get("$this->baseURL/1");
        $responseInvalid = $this->withHeaders($this->headers)->get("$this->baseURL/100");

        $responseValid
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json) =>
                $json
                    ->hasAll(
                        'imageId',
                        'imageName',
                        'imageAlt',
                    )
                    ->whereAll([
                        'imageId' => 1,
                        'imageName' => 'granplus-dog_tzvqbg',
                        'imageAlt' => 'An image'
                    ])
            );

        $responseInvalid->assertNotFound();
    }

    /**
     * Check if the route /images can create a image
     *
     *@doesNotPerformAssertions
     */
    public function testCreateImage(): void
    {
        $image = [
            'imageName' => 'services_vk86n6',
            'imageAlt' => 'An image'
        ];

        $responseValid = $this
            ->withHeader('Authorization', 'Bearer '.$this->login['access_token'])
            ->withHeaders($this->headers)
            ->post("$this->baseURL/1", $image);

        $responseValid
            ->assertCreated()
            ->assertJson(
                fn(AssertableJson $json) =>
                $json
                    ->hasAll('imageId', 'imageName', 'imageAlt')
                    ->whereAll([
                        'imageName' => 'services_vk86n6',
                        'imageAlt' => 'An image'
                    ])
            );
    }

    /**
     * Check if the route /images can update a category
     *
     *@doesNotPerformAssertions
     */
    public function testUpdateImage(): void
    {
        $image = [
            'imageName' => 'services_vk86n6',
            'imageAlt' => 'An image'
        ];

        $responseValid = $this
            ->withHeader('Authorization', 'Bearer '.$this->login['access_token'])
            ->withHeaders($this->headers)
            ->put("$this->baseURL/1", $image);

        $responseValid
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json) =>
                $json
                    ->hasAll(
                        'imageId',
                        'imageName',
                        'imageAlt',
                    )
                    ->whereAll([
                        'imageId' => 1,
                        'imageName' => 'services_vk86n6',
                        'imageAlt' => 'An image'
                    ])
            );
    }

    public function testDeleteImage(): void
    {
        $responseValid = $this->withHeaders($this->headers)->delete("$this->baseURL/1");
        $responseNotFoundProduct = $this->delete("$this->baseURL/1");

        $responseValid->assertOk();
        $responseNotFoundProduct->assertNotFound();
    }
}
