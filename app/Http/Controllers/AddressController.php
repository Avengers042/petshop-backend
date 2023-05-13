<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Http\Resources\AddressResource;
use App\Http\Resources\AddressCollection;
use App\Models\Address;

class AddressController extends Controller {

    public function index() {
        return response()->json(new AddressCollection(Address::all()));
    }

    public function store(StoreAddressRequest $request) {
        try {
            new AddressResource(Address::create($request->all()));
            return response('Endereço cadastrado com sucesso.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function show(Address $address) {
        return response()->json(new AddressResource($address));
    }

    public function update(UpdateAddressRequest $request, Address $address) {
        if(!$address){
            return response('Endereço não cadastrado.');
        }

        try {
            new AddressResource($address->update($request->all()));

            return response('Endereço atualizado.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(Address $address) {
        if(!$address){
            return response('Endereço não cadastrado.');
        }

        try {
            $address->delete();

            return response('Endereço excluído.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
