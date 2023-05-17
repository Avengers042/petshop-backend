<?php

namespace Tests\Feature;

use Database\Seeders\PurchaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;
    protected $baseURL = '/api/purchases';
    protected $seeder = PurchaseSeeder::class;
    protected $headers = ['Accept' => 'application/json'];

    /**
     * Check if the route /purchases return all 25 purchases registers
     */
    public function testGetAllPurchases() : void
    {
        $response = $this->withHeaders($this->headers)->get("$this->baseURL");
        $response->assertStatus(200)->assertJsonCount(25, 'data');
    }

    /**
     * Check if the route /purchases return one value
     */
    public function testGetOnePurchase() : void
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
                            ->hasAll('purchaseId', 'productId', 'userId')
                            ->where('purchaseId', 1)
                    ));

        $responseInvalid->assertNotFound();
    }

    /**
     * Check if the route /purchases can create a purchase
     */
    public function testCreatePurchase() : void
    {
        $purchase = [
            'productId' => 1,
            'userId' => 1
        ];

        $purchaseInvalid = [
            'productId' => 100,
            'userId' => 100
        ];

        $responseValid = $this->withHeaders($this->headers)->post("$this->baseURL", $purchase);
        $responseInvalid = $this->post("$this->baseURL", ['productId' => 1]);
        $responseNull = $this->post("$this->baseURL");
        $responseNotFoundProduct = $this->post("$this->baseURL", $purchaseInvalid);

        $responseValid
            ->assertCreated()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('data')
                    ->has('data', fn (AssertableJson $json) =>
                        $json
                            ->hasAll('purchaseId', 'productId', 'userId')
                            ->where('productId', 1)
                            ->where('userId', 1)
                    )
            );

        $responseInvalid->assertUnprocessable();
        $responseNull->assertUnprocessable();
        $responseNotFoundProduct->assertServiceUnavailable();
    }

    /**
     * Check if the route /purchases can update a purchase
     */
    public function testUpdatePurchase() : void
    {
        $purchase = [
            'productId' => 2,
            'userId' => 2
        ];

        $purchaseInvalid = [
            'productId' => 100,
            'userId' => 100
        ];

        $responseValid = $this->withHeaders($this->headers)->put("$this->baseURL/1", $purchase);
        $responseInvalid = $this->put("$this->baseURL/1", ['productId' => 1]);
        $responseNull = $this->put("$this->baseURL/1");
        $responseNotFoundProduct = $this->put("$this->baseURL/1", $purchaseInvalid);

        $responseValid
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('data')
                    ->has('data', fn (AssertableJson $json) =>
                        $json
                            ->hasAll('purchaseId', 'productId', 'userId')
                            ->where('productId', 2)
                            ->where('userId', 2)
                    )
            );

        $responseInvalid->assertUnprocessable();
        $responseNull->assertUnprocessable();
        $responseNotFoundProduct->assertServiceUnavailable();
    }

    /**
     * Check if the route /purchases can delete a purchase
     */
    public function testDeletePurchase() : void
    {
        $responseValid = $this->withHeaders($this->headers)->delete("$this->baseURL/1");
        $responseNotFoundProduct = $this->delete("$this->baseURL/1");

        $responseValid->assertOk();
        $responseNotFoundProduct->assertNotFound();
    }
}