<?php

namespace Tests\Feature;

use Database\Seeders\AddressSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use DatabaseMigrations, WithFaker;
    protected $baseURL = '/api/addresses';
    protected $seeder = AddressSeeder::class;
    protected $headers = ['Accept' => 'application/json'];

    public function testGetAllAddresses() : void
    {
        $response = $this->withHeaders($this->headers)->get("$this->baseURL");
        $response->assertStatus(200)->assertJsonCount(25);
    }

    /**
     * Check if the route /addresses return one value
     */
    public function testGetOneAddress() : void
    {
        $responseValid = $this->withHeaders($this->headers)->get("$this->baseURL/1");
        $responseInvalid = $this->withHeaders($this->headers)->get("$this->baseURL/100");

        $responseValid
            ->assertOk()
            ->assertJson(
                fn (AssertableJson $json) =>
                $json
                    ->hasAll(
                        'addressId',
                        'number',
                        'cep',
                        'uf',
                        'district',
                        'publicPlace',
                        'complement'
                    )
                    ->where('addressId', 1)
            );

        $responseInvalid->assertNotFound();
    }
}