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

    public function testGetAllImages() : void
    {
        $response = $this->withHeaders($this->headers)->get("$this->baseURL");

        $response->assertStatus(200)->assertJsonCount(25);
    }

    public function testGetOneImage() : void
    {
        $responseValid = $this->withHeaders($this->headers)->get("$this->baseURL/1");
        $responseInvalid = $this->withHeaders($this->headers)->get("$this->baseURL/100");

        $responseValid
            ->assertOk()
            ->assertJson(
                fn (AssertableJson $json) =>
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
}