<?php

namespace tests\Feature;

use Database\Seeders\ProductSeeder;
use Database\Seeders\StockSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class StockTest extends TestCase
{
    use RefreshDatabase;
    protected $baseURL = '/api/stocks';
    protected $seeder = [StockSeeder::class, ProductSeeder::class];
    protected $headers = ['Accept' => 'application/json'];

    /**
     * Check if the route /purchases return all 25 purchases registers
     */
    public function testGetAllStocks() : void
    {
        $response = $this->withHeaders($this->headers)->get("$this->baseURL");
        $response->assertStatus(200)->assertJsonCount(25, 'data');
    }

    /**
     * Check if the route /purchases return one value
     */
    public function testGetOneStock() : void
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
                            ->hasAll('productId', 'amount')
                            ->where('productId', 1)
                    ));

        $responseInvalid->assertNotFound();
    }

    /**
     * Check if the route /purchases can create a purchase
     */
    public function testCreateStock() : void
    {
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
                    ->has('data')
                    ->has('data', fn (AssertableJson $json) =>
                        $json
                            ->hasAll('productId', 'amount')
                            ->where('productId', 1)
                            ->where('amount', 5)
                    )
            );

        $responseInvalid->assertUnprocessable();
        $responseNull->assertUnprocessable();
        $responseNotFoundProduct->assertServiceUnavailable();
    }

    /**
     * Check if the route /purchases can update a purchase
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
                    ->has('data')
                    ->has('data', fn (AssertableJson $json) =>
                        $json
                            ->hasAll('productId', 'amount')
                            ->where('productId', 1)
                            ->where('amount', 5)
                    )
            );

        $responseInvalid->assertUnprocessable();
        $responseNull->assertUnprocessable();
        $responseNotFoundProduct->assertNotFound();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testDeleteStock(): void
    {
        //todo
    }
}
