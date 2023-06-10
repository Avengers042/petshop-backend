<?php

namespace tests\Feature;

use Database\Seeders\CategorySeeder;
use Database\Seeders\StockSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class StockTest extends TestCase
{
    use DatabaseMigrations;
    protected $baseURL = '/api/stocks';
    protected $seeder = CategorySeeder::class;
    protected $headers = ['Accept' => 'application/json'];

    protected function setUp(): void
    {
        parent::setUp();
        (new StockSeeder)->run();
    }

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
}