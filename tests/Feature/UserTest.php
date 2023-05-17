<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    protected $baseURL = '/api/users';
    protected $seeder = UserSeeder::class;
    protected $headers = ['Accept' => 'application/json'];

    /**
     * Check if the route /users return all 25 users registers
     */
    public function testGetAllUsers() : void
    {
        $response = $this->withHeaders($this->headers)->get("$this->baseURL");
        $response->assertStatus(200)->assertJsonCount(25, 'data');
    }

    /**
     * Check if the route /users return one value
     */
    public function testGetOneUser() : void
    {
        $responseValid = $this->withHeaders($this->headers)->get("$this->baseURL/1");
        $responseInvalid = $this->withHeaders($this->headers)->get("$this->baseURL/100");

        $responseValid
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('data')
                    ->has('data', fn (AssertableJson $json) =>
                        $json
                            ->hasAll('userId', 'firstName', 'lastName', 'cpf', 'email', 'age', 'password', 'addressId')
                            ->where('userId', 1)
                    ));

        $responseInvalid->assertNotFound();
    }

    /**
     * Check if the route /users can create a user
     */
    public function testCreateUser() : void
    {
        $user = [
            'firstName' => 1,
            'lastName' => 1,
            'cpf' => 1,
            'email' => 1,
            'age' => 1,
            'password' => 1,
            'addressId' => 1
        ];

        $userInvalid = [
            'firstName' => 100,
            'lastName' => 100,
            'cpf' => 100,
            'email' => 100,
            'age' => 100,
            'password' => 100,
            'addressId' => 100,
        ];

        $responseValid = $this->withHeaders($this->headers)->post("$this->baseURL", $user);
        $responseInvalid = $this->post("$this->baseURL", ['addressId' => 1]);
        $responseNull = $this->post("$this->baseURL");
        $responseNotFoundProduct = $this->post("$this->baseURL", $userInvalid);

        $responseValid
            ->assertCreated()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('data')
                    ->has('data', fn (AssertableJson $json) =>
                        $json
                            ->hasAll('userId', 'firstName', 'lastName', 'cpf', 'email', 'age', 'password', 'addressId')
                            ->where('addressId', 1)
                    )
            );

        $responseInvalid->assertUnprocessable();
        $responseNull->assertUnprocessable();
        $responseNotFoundProduct->assertServiceUnavailable();
    }

    /**
     * Check if the route /users can update a user
     */
    public function testUpdateUser() : void
    {
        $user = [
            'firstName' => 2,
            'lastName' => 2,
            'cpf' => 2,
            'email' => 2,
            'age' => 2,
            'password' => 2,
            'addressId' => 2
        ];

        $userInvalid = [
            'firstName' => 100,
            'lastName' => 100,
            'cpf' => 100,
            'email' => 100,
            'age' => 100,
            'password' => 100,
            'addressId' => 100
        ];

        $responseValid = $this->withHeaders($this->headers)->put("$this->baseURL/1", $user);
        $responseInvalid = $this->put("$this->baseURL/1", ['addressId' => 1]);
        $responseNull = $this->put("$this->baseURL/1");
        $responseNotFoundProduct = $this->put("$this->baseURL/1", $userInvalid);

        $responseValid
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('data')
                    ->has('data', fn (AssertableJson $json) =>
                        $json
                            ->hasAll('userId', 'firstName', 'lastName', 'cpf', 'email', 'age', 'password', 'addressId')
                            ->where('addressId', 2)
                    )
            );

        $responseInvalid->assertUnprocessable();
        $responseNull->assertUnprocessable();
        $responseNotFoundProduct->assertServiceUnavailable();
    }

    /**
     * Check if the route /users can delete a user
     * @doesNotPerformAssertions
     */
    public function testDeleteUser() : void
    {
        //todo
    }
}
