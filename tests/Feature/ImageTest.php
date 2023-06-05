<?php

namespace Tests\Feature;

use Database\Seeders\ImageSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ImageTest extends TestCase
{
    use DatabaseMigrations;
    protected $baseURL = '/api/images';
    protected $seeder = ImageSeeder::class;
    protected $headers = ['Accept' => 'application/json'];

    /**
     * Check if the route /images return all 25 images registers
     */
    public function testGetAllImages() : void
    {
        $response = $this->withHeaders($this->headers)->get("$this->baseURL");

        $response->assertStatus(200)->assertJsonCount(25);
    }

    /**
     * Check if the route /images return one value
     */
    public function testGetOneImage() : void
    {
        $responseValid = $this->withHeaders($this->headers)->get("$this->baseURL/1");
        $responseInvalid = $this->withHeaders($this->headers)->get("$this->baseURL/100");

        $responseValid
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
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
     */
    public function testCreateImage() : void
    {
        $image = [
            'imageName' => 'services_vk86n6',
            'imageAlt' => 'An image'
        ];

        $imageInvalid = [
            'imageName' => 'services_vk86n6',
        ];

        $responseValid = $this->withHeaders($this->headers)->post("$this->baseURL", $image);
        $responseInvalid = $this->post("$this->baseURL", $imageInvalid);
        $responseNull = $this->post("$this->baseURL");

        $responseValid
            ->assertCreated()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->hasAll('imageId', 'imageName', 'imageAlt')
                    ->whereAll([
                        'imageName' => 'services_vk86n6',
                        'imageAlt' => 'An image'
                    ])
            );

        $responseInvalid->assertUnprocessable();
        $responseNull->assertUnprocessable();
    }

    /**
     * Check if the route /images can update a image
     */
    public function testUpdateImage() : void
    {
        $image = [
            'imageName' => 'services_vk86n6',
            'imageAlt' => 'An image'
        ];

        $imageInvalid = [
            'imageName' => 'services_vk86n6',
        ];

        $responseValid = $this->withHeaders($this->headers)->put("$this->baseURL/1", $image);
        $responseInvalid = $this->put("$this->baseURL/1", $imageInvalid);
        $responseNull = $this->put("$this->baseURL/1");
        $responseNotFoundProduct = $this->put("$this->baseURL/100", $image);

        $responseValid
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
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

        $responseInvalid->assertUnprocessable();
        $responseNull->assertUnprocessable();
        $responseNotFoundProduct->assertNotFound();
    }

    /**
     * Check if the route /images can delete a image
     * 
     * @doesNotPerformAssertions
     */
    public function testDeleteImage() : void
    {
        // TO DO
    }
}