<?php

namespace App\Http\Controllers;

use App\Http\Requests\Address\StoreAddressRequest;
use App\Http\Requests\Address\UpdateAddressRequest;
use App\Http\Resources\Address\AddressResource;
use App\Http\Resources\Address\AddressCollection;
use App\Models\Address;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(new AddressCollection(Address::all()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request)
    {
        return response()->json(new AddressResource(Address::create($request->all())))->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Address $address)
    {
        return response()->json(new AddressResource($address));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, Address $address)
    {
        return response()->json(new AddressResource(tap($address)->update($request->all())));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        return response()->json(new AddressResource(tap($address)->delete()));
    }
}
