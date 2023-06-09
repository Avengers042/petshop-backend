<?php

namespace Tests\Feature;

use Database\Seeders\PurchaseSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use DatabaseMigrations;
    protected $baseURL = '/api/purchases';
    protected $seeder = PurchaseSeeder::class;
    protected $headers = ['Accept' => 'application/json'];

    /**
     * Check if the route /purchases return all 25 purchases registers
     * 
     * @doesNotPerformAssertions
     */
    public function testGetAllPurchases() : void
    {
        //todo
    }

    /**
     * Check if the route /purchases return one value
     * 
     * @doesNotPerformAssertions
     */
    public function testGetOnePurchase() : void
    {
        //todo
    }

    /**
     * Check if the route /purchases can update a purchase
     * 
     * @doesNotPerformAssertions
     */
    public function testUpdatePurchase() : void
    {
        //todo
    }


    /**
     * Check if the route /purchases can delete a purchase
     * 
     * @doesNotPerformAssertions
     */
    public function testDeletePurchase() : void
    {
        //todo
    }
}