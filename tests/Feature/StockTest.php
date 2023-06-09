<?php

namespace tests\Feature;

use App\Models\Product;
use Database\Seeders\StockSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class StockTest extends TestCase
{
    use DatabaseMigrations, WithFaker;
    protected $baseURL = '/api/stocks';
    protected $seeder = StockSeeder::class;
    protected $headers = ['Accept' => 'application/json'];

    /**
     * Check if the route /stocks return all 25 stocks registers
     */
    public function testGetAllStocks() : void
    {
        $response = $this->withHeaders($this->headers)->get("$this->baseURL");
        $response->assertStatus(200)->assertJsonCount(25);
    }

    /**
     * Check if the route /stocks return one value
     */
    public function testGetOneStock() : void
    {
        $responseValid = $this->withHeaders($this->headers)->get("$this->baseURL/1");
        $responseInvalid = $this->withHeaders($this->headers)->get("$this->baseURL/100");

        $responseValid
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->hasAll('productId', 'amount')
                    ->where('productId', 1));

        $responseInvalid->assertNotFound();
    }

    /**
     * Check if the route /stocks can create a stock
     *
     * @doesNotPerformAssertions
     */
    public function testCreateStock() : void
    {
        //todo
    }

    /**
     * Check if the route /stocks can update a stock
     *
     * @doesNotPerformAssertions
     */
    public function testUpdateStock() : void
    {
        //todo
    }

    /**
     * Check if the route /stocks can delete a stock
     *
     * @doesNotPerformAssertions
     */
    public function testDeleteStock() : void
    {
        //todo
    }
}