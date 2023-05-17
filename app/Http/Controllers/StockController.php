<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use App\Http\Requests\Stock\UpdateStockRequest;
use App\Http\Requests\Stock\StoreStockRequest;
use App\Http\Resources\Stock\StockResource;
use App\Http\Resources\Stock\StockCollection;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new StockCollection(Stock::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStockRequest $request)
    {
        return new StockResource(Stock::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Stock $stock)
    {
        return new StockResource($stock);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStockRequest $request, Stock $stock)
    {
        $stock->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        $stock->delete();
    }
}