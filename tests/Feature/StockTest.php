<?php

namespace tests\Feature;

use App\Models\Product;
use Database\Seeders\StockSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class StockTest extends TestCase
{
    use RefreshDatabase;
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
     */
    public function testCreateStock() : void
    {
        Product::factory()->create();
        
        $stock = [
            'productId' => 1,
            'amount' => 55
        ];

        $stockInvalid = [
            'productId' => 100,
            'amount' => 0
        ];

        $responseValid = $this->withHeaders($this->headers)->post("$this->baseURL", $stock);
        $responseInvalid = $this->post("$this->baseURL", ['productId' => 100]);
        $responseNull = $this->post("$this->baseURL");
        $responseNotFoundProduct = $this->post("$this->baseURL", $stockInvalid);

        $responseValid
            ->assertCreated()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->hasAll('productId', 'amount')
                    ->where('productId', 1)
                    ->where('amount', 55)
            );

        $responseInvalid->assertUnprocessable();
        $responseNull->assertUnprocessable();
        $responseNotFoundProduct->assertServiceUnavailable();
    }

    /**
     * Check if the route /stocks can update a stock
     */
    public function testUpdateStock() : void
    {
        $stock = [
            'productId' => 1,
            'amount' => 5
        ];

        $stockInvalid = [
            'productId' => 100,
            'amount' => 0
        ];

        $responseValid = $this->withHeaders($this->headers)->put("$this->baseURL/1", $stock);
        $responseInvalid = $this->put("$this->baseURL/1", ['productId' => 1]);
        $responseNull = $this->put("$this->baseURL/1");
        $responseNotFoundProduct = $this->put("$this->baseURL/100", $stockInvalid);

        $responseValid
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->hasAll('productId', 'amount')
                    ->where('productId', 1)
                    ->where('amount', 5)
            );

        $responseInvalid->assertUnprocessable();
        $responseNull->assertUnprocessable();
        $responseNotFoundProduct->assertNotFound();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testDeleteStock() : void
    {
        //todo
    }
}