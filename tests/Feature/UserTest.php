<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations, WithFaker;
    protected $baseURL = '/api/users';
    protected $seeder = UserSeeder::class;
    protected $headers = ['Accept' => 'application/json'];
    protected $baseValidUser = [
        'firstName' => 'Agustina',
        'lastName' => 'das Neves',
        'cpf' => '00000000000',
        'email' => 'testing@testing.com',
        'birthday' => '2022-10-26',
        'password' => 'teste',
        'addressId' => 1,
        'shoppingCartId' => 1
    ];

    protected $baseLoginUser = [
        'email' => 'testing@testing.com',
        'password' => 'teste',
    ];

    /**
     * Check if the route /users return all 25 users registers
     */
    public function testGetAllUsers() : void
    {
        $response = $this->withHeaders($this->headers)->get("$this->baseURL");
        $response->assertStatus(200)->assertJsonCount(25);
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
                    ->hasAll(
                        'userId',
                        'firstName',
                        'lastName',
                        'cpf',
                        'email',
                        'birthday',
                        'password',
                        'addressId',
                        'shoppingCartId'
                    )
                    ->where('userId', 1)
            );

        $responseInvalid->assertNotFound();
    }

    /**
     * Check if the route /users can create a user
     * 
     * @doesNotPerformAssertions
     */
    public function testCreateUser() : void
    {
        //todo
    }

    /**
     * Check if the route /users can update a user
     * 
     * @doesNotPerformAssertions
     */
    public function testUpdateUser() : void
    {
        //todo
    }

    /**
     * Check if the route /users can delete a user
     * 
     * @doesNotPerformAssertions
     */
    public function testDeleteUser() : void
    {
        //todo
    }
}