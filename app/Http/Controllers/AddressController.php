<?php

namespace App\Http\Controllers;

use App\Http\Requests\Address\StoreAddressRequest;
use App\Http\Requests\Address\UpdateAddressRequest;
use App\Http\Resources\Address\AddressResource;
use App\Http\Resources\Address\AddressCollection;
use App\Models\Address;

class AddressController extends Controller {

    public function index() {
        return new AddressCollection(Address::all());
    }

    public function store(StoreAddressRequest $request) {
        return new AddressResource(Address::create($request->all()));
    }

    public function show(Address $address) {
        return new AddressResource($address);
    }

    public function update(UpdateAddressRequest $request, Address $address) {
        return $address->update($request->all());
    }

    public function destroy(Address $address) {
        return $address->delete();
    }
}
