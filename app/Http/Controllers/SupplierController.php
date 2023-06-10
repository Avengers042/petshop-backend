<?php

namespace App\Http\Controllers;

use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Http\Requests\Supplier\UpdateSupplierRequest;
use App\Http\Resources\Supplier\SupplierCollection;
use App\Http\Resources\Supplier\SupplierResource;
use App\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(new SupplierCollection(Supplier::all()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        return response()->json(new SupplierResource(Supplier::create($request->all())))->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return response()->json(new SupplierResource($supplier));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        return response()->json(new SupplierResource(tap($supplier)->update($request->all())));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        return response()->json(new SupplierResource(tap($supplier)->delete()));
    }
}