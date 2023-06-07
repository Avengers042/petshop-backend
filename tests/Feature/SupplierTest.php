<?php

namespace Tests\Feature;

use Database\Seeders\SupplierSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class SupplierTest extends TestCase
{
    use DatabaseMigrations;
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

    /**
     * Check if the route /suppliers can create a supplier
     */
    public function testCreateSupplier() : void
    {
        $supplier = [
            'corporateName' => 'Empresa LTDA',
            'tradeName' => 'Empresa',
            'cnpj' => '30168490000109',
            'email' => 'teste@teste.com',
            'commercialPhone' => "(99) 9999-9999",
            'addressId' => 1
        ];

        $supplierInvalid = [
            'corporateName' => 'Empresa LTDA',
            'tradeName' => 'Empresa',
            'cnpj' => '30168490000109',
            'email' => 'teste@teste.com',
            'commercialPhone' => "(99) 9999-9999",
            'addressId' => 1
        ];

        $supplierNotFound = [
            'corporateName' => 'Empresa LTDA',
            'tradeName' => 'Empresa',
            'cnpj' => '30168490000999',
            'email' => 'testing@testing.com',
            'commercialPhone' => "(99) 9999-9999",
            'addressId' => 100
        ];

        $responseValid = $this->withHeaders($this->headers)->post("$this->baseURL", $supplier);
        $responseInvalid = $this->post("$this->baseURL", $supplierInvalid);
        $responseNull = $this->post("$this->baseURL");
        $responseNotFoundProduct = $this->post("$this->baseURL", $supplierNotFound);

        $responseValid
            ->assertCreated()
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
                    ->whereAll([
                        'corporateName' => 'Empresa LTDA',
                        'tradeName' => 'Empresa',
                        'cnpj' => '30168490000109',
                        'email' => 'teste@teste.com',
                        'commercialPhone' => "(99) 9999-9999",
                        'addressId' => 1
                    ])
            );

        $responseInvalid->assertUnprocessable();
        $responseNull->assertUnprocessable();
        $responseNotFoundProduct->assertServiceUnavailable();
    }

    /**
     * Check if the route /suppliers can update a supplier
     */
    public function testUpdateSupplier() : void
    {
        $supplier = [
            'corporateName' => 'Empresa LTDA',
            'tradeName' => 'Empresa',
            'cnpj' => '30168490000109',
            'email' => 'teste@email.com',
            'commercialPhone' => "(99) 9999-9999",
            'addressId' => 1
        ];

        $supplierInvalid = [
            'corporateName' => 'Empresa LTDA',
            'tradeName' => 'Empresa',
            'cnpj' => '30168490000109',
            'email' => 'teste@teste.com',
            'commercialPhone' => "(99) 9999-9999",
            'addressId' => 1
        ];

        $responseValid = $this->withHeaders($this->headers)->put("$this->baseURL/1", $supplier);
        $responseInvalid = $this->put("$this->baseURL/1", $supplierInvalid);
        $responseNull = $this->put("$this->baseURL/1");
        $responseNotFoundProduct = $this->put("$this->baseURL/100", $supplier);

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
                    ->whereAll([
                        'corporateName' => 'Empresa LTDA',
                        'tradeName' => 'Empresa',
                        'cnpj' => '30168490000109',
                        'email' => 'teste@email.com',
                        'commercialPhone' => "(99) 9999-9999",
                        'addressId' => 1
                    ])
            );

        $responseInvalid->assertUnprocessable();
        $responseNull->assertUnprocessable();
        $responseNotFoundProduct->assertNotFound();
    }

    /**
     * Check if the route /suppliers can delete a supplier
     * 
     * @doesNotPerformAssertions
     */
    public function testDeleteSupplier() : void
    {
        // TO DO
    }
}