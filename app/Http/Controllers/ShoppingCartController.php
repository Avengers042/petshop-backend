<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShoppingCart\StoreShoppingCartRequest;
use App\Http\Requests\ShoppingCart\UpdateShoppingCartRequest;
use App\Http\Resources\ShoppingCart\ShoppingCartCollection;
use App\Http\Resources\ShoppingCart\ShoppingCartResource;
use App\Models\ShoppingCart;

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
        $shoppingCart = ShoppingCart::create([
            'product_id' => $request->input('productId'),
            'amount' => $request->input('amount'),
        ]);

        return response()->json(new ShoppingCartResource($shoppingCart))->setStatusCode(201);
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
        $shoppingCart->amount = $request->input('amount');
        $shoppingCart->save();

        return response()->json(new ShoppingCartResource($shoppingCart));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShoppingCart $shoppingCart)
    {
        $shoppingCart->delete();

        return response()->json(null)->setStatusCode(204);
    }
}
