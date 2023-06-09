<?php

namespace Tests\Feature;

use Database\Seeders\SupplierSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class SupplierTest extends TestCase
{
    use DatabaseMigrations, WithFaker;
    protected $baseURL = '/api/suppliers';
    protected $seeder = SupplierSeeder::class;
    protected $headers = ['Accept' => 'application/json'];

    /**
     * Check if the route /suppliers return all 25 suppliers registers
     */
    public function testGetAllSuppliers() : void
    {
        $response = $this->withHeaders($this->headers)->get("$this->baseURL");

        $response->assertStatus(200)->assertJsonCount(25);
    }

    /**
     * Check if the route /suppliers return one value
     */
    public function testGetOneSupplier() : void
    {
        $responseValid = $this->withHeaders($this->headers)->get("$this->baseURL/1");
        $responseInvalid = $this->withHeaders($this->headers)->get("$this->baseURL/100");

        $responseValid
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->hasAll(
                        'supplierId',
                        'corporateName',
                        'tradeName',
                        'cnpj',
                        'email',
                        'commercialPhone',
                        'addressId'
                    )
                    ->where('supplierId', 1)
            );

        $responseInvalid->assertNotFound();
    }
}