<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations, WithFaker;
    protected $baseURL = '/api/users';
    protected $seeder = UserSeeder::class;
    protected $headers = ['Accept' => 'application/json'];

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
                    ->hasAll('userId', 'firstName', 'lastName', 'cpf', 'email', 'birthday', 'password', 'addressId')
                    ->where('userId', 1)
            );

        $responseInvalid->assertNotFound();
    }

    /**
     * Check if the route /users can create a user
     */
    public function testCreateUser() : void
    {
        $user = [
            'firstName' => $this->faker->firstName(),
            'lastName' => $this->faker->lastName(),
            'cpf' => $this->faker->cpf(false),
            'email' => $this->faker->safeEmail(),
            'birthday' => '2014-06-28',
            'password' => 'password',
            'addressId' => 1
        ];

        $userNotFoundAddres = [
            'firstName' => $this->faker->firstName(),
            'lastName' => $this->faker->lastName(),
            'cpf' => $this->faker->cpf(false),
            'email' => $this->faker->safeEmail(),
            'birthday' => '2014-06-28',
            'password' => 'password',
            'addressId' => 500,
        ];

        $responseValid = $this->withHeaders($this->headers)->post("$this->baseURL", $user);
        $responseInvalid = $this->post("$this->baseURL", ['addressId' => 1]);
        $responseNull = $this->post("$this->baseURL");
        $responseNotFoundAddress = $this->post("$this->baseURL", $userNotFoundAddres);

        $responseValid
            ->assertCreated()
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
                        'addressId'
                    )
                    ->whereAll([
                        'firstName' => $user['firstName'],
                        'lastName' => $user['lastName'],
                        'cpf' => $user['cpf'],
                        'email' => $user['email'],
                        'birthday' => $user['birthday'],
                        'password' => fn (string $password) => Hash::check('password', $password),
                        'addressId' => 1
                    ])
            );

        $responseInvalid->assertUnprocessable();
        $responseNull->assertUnprocessable();
        $responseNotFoundAddress->assertServiceUnavailable();
    }

    /**
     * Check if the route /users can update a user
     */
    public function testUpdateUser() : void
    {
        $user = [
            'firstName' => $this->faker->firstName(),
            'lastName' => $this->faker->lastName(),
            'cpf' => $this->faker->cpf(false),
            'email' => $this->faker->safeEmail(),
            'birthday' => '2014-06-28',
            'password' => 'password2',
            'addressId' => 1
        ];

        $responseValid = $this->withHeaders($this->headers)->put("$this->baseURL/1", $user);
        $responseInvalid = $this->put("$this->baseURL/1", ['addressId' => 1]);
        $responseNull = $this->put("$this->baseURL/1");
        $responseNotFoundUser = $this->put("$this->baseURL/1000", $user);

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
                        'addressId'
                    )
                    ->whereAll([
                        'userId' => 1,
                        'firstName' => $user['firstName'],
                        'lastName' => $user['lastName'],
                        'cpf' => $user['cpf'],
                        'email' => $user['email'],
                        'birthday' => $user['birthday'],
                        'password' => fn (string $password) => Hash::check('password2', $password),
                        'addressId' => 1
                    ])
            );

        $responseInvalid->assertUnprocessable();
        $responseNull->assertUnprocessable();
        $responseNotFoundUser->assertNotFound();
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