<?php

namespace App\Http\Controllers;

use App\Models\ShoppingCart;
use App\Http\Requests\ShoppingCart\UpdateShoppingCartRequest;
use App\Http\Requests\ShoppingCart\StoreShoppingCartRequest;
use App\Http\Resources\ShoppingCart\ShoppingCartResource;
use App\Http\Resources\ShoppingCart\ShoppingCartCollection;
use Illuminate\Support\Facades\Log;

class ShoppingCartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(new ShoppingCartCollection(ShoppingCart::all()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShoppingCartRequest $request)
    {
        return response()->json(new ShoppingCartResource(ShoppingCart::create($request->all())))->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ShoppingCart $shoppingCart)
    {
        return response()->json(new ShoppingCartResource($shoppingCart));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShoppingCartRequest $request, ShoppingCart $shoppingCart)
    {
        return response()->json(new ShoppingCartResource(tap($shoppingCart)->update($request->all())));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShoppingCart $shoppingCart)
    {
        return response()->json(new ShoppingCartResource(tap($shoppingCart)->delete()));
    }
}
