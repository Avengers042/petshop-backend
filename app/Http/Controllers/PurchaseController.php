<?php

namespace App\Http\Controllers;

use App\Http\Requests\Purchase\StorePurchaseRequest;
use App\Http\Requests\Purchase\UpdatePurchaseRequest;
use App\Http\Resources\Purchase\PurchaseCollection;
use App\Http\Resources\Purchase\PurchaseResource;
use App\Models\Purchase;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(new PurchaseCollection(Purchase::all()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseRequest $request)
    {
        return response()->json(new PurchaseResource(Purchase::create($request->all())))->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        return response()->json(new PurchaseResource($purchase));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        return response()->json(new PurchaseResource(tap($purchase)->update($request->all())));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        return response()->json(new PurchaseResource(tap($purchase)->delete()));
    }
}
