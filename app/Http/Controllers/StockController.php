<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Http\Requests\Stock\UpdateStockRequest;
use App\Http\Requests\Stock\StoreStockRequest;
use App\Http\Resources\Stock\StockResource;
use App\Http\Resources\Stock\StockCollection;
use Illuminate\Support\Facades\Log;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(new StockCollection(Stock::all()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStockRequest $request)
    {
        Log::info($request);
        return response()->json(new StockResource(Stock::create($request->all())))->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Stock $stock)
    {
        return response()->json(new StockResource($stock));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStockRequest $request, Stock $stock)
    {
        return response()->json(new StockResource(tap($stock)->update($request->all())));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        return response()->json(new StockResource(tap($stock)->delete()));
    }
}
