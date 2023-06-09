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

    public function testGetAllAddresses(): void
    {
        $response = $this->withHeaders($this->headers)->get("$this->baseURL");

        $response->assertStatus(200)->assertJsonCount(10); // Altere o valor esperado conforme a quantidade de endereços na seeder
    }

    public function testGetOneAddress(): void
    {
        $responseValid = $this->withHeaders($this->headers)->get("$this->baseURL/1");
        $responseInvalid = $this->withHeaders($this->headers)->get("$this->baseURL/100");

        $responseValid
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json) =>
                $json
                    ->hasAll(
                        'addressId',
                        'NUMBER',
                        'CEP',
                        'UF',
                        'DISTRICT',
                        'PUBLIC_PLACE',
                        'COMPLEMENT'
                    )
                    ->whereAll([
                        'addressId' => 1,
                        'NUMBER' => '123',
                        'CEP' => '12345-678',
                        'UF' => 'SP',
                        'DISTRICT' => 'District 1',
                        'PUBLIC_PLACE' => 'Street 1',
                        'COMPLEMENT' => 'Apt 1'
                    ])
            );

        $responseInvalid->assertNotFound();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testCreateAddress(): void
    {
        $address = [
            'NUMBER' => '456',
            'CEP' => '98765-432',
            'UF' => 'RJ',
            'DISTRICT' => 'District 2',
            'PUBLIC_PLACE' => 'Street 2',
            'COMPLEMENT' => 'Apt 2'
        ];

        $responseValid = $this
            ->withHeader('Authorization', 'Bearer '.$this->login['access_token'])
            ->withHeaders($this->headers)
            ->post("$this->baseURL/1", $address);

        $responseValid
            ->assertCreated()
            ->assertJson(
                fn(AssertableJson $json) =>
                $json
                    ->hasAll(
                        'addressId',
                        'NUMBER',
                        'CEP',
                        'UF',
                        'DISTRICT',
                        'PUBLIC_PLACE',
                        'COMPLEMENT'
                    )
                    ->whereAll([
                        'NUMBER' => '456',
                        'CEP' => '98765-432',
                        'UF' => 'RJ',
                        'DISTRICT' => 'District 2',
                        'PUBLIC_PLACE' => 'Street 2',
                        'COMPLEMENT' => 'Apt 2'
                    ])
            );
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testUpdateAddress(): void
    {
        $address = [
            'NUMBER' => '789',
            'CEP' => '54321-876',
            'UF' => 'MG',
            'DISTRICT' => 'District 3',
            'PUBLIC_PLACE' => 'Street 3',
            'COMPLEMENT' => 'Apt 3'
        ];

        $responseValid = $this
            ->withHeader('Authorization', 'Bearer '.$this->login['access_token'])
            ->withHeaders($this->headers)
            ->put("$this->baseURL/1", $address);

        $responseValid
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json) =>
                $json
                    ->hasAll(
                        'addressId',
                        'NUMBER',
                        'CEP',
                        'UF',
                        'DISTRICT',
                        'PUBLIC_PLACE',
                        'COMPLEMENT'
                    )
                    ->whereAll([
                        'addressId' => 1,
                        'NUMBER' => '789',
                        'CEP' => '54321-876',
                        'UF' => 'MG',
                        'DISTRICT' => 'District 3',
                        'PUBLIC_PLACE' => 'Street 3',
                        'COMPLEMENT' => 'Apt 3'
                    ])
            );
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testDeleteAddress(): void
    {
        $responseValid = $this->withHeaders($this->headers)->delete("$this->baseURL/1");
        $responseNotFound = $this->delete("$this->baseURL/1");

        $responseValid->assertOk();
        $responseNotFound->assertNotFound();
    }
}
