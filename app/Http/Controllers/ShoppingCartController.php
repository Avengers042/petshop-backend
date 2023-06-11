<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShoppingCart\FinishShoppingCartRequest;
use App\Http\Requests\ShoppingCart\StoreShoppingCartRequest;
use App\Http\Requests\ShoppingCart\UpdateShoppingCartRequest;
use App\Http\Requests\Stock\UpdateStockRequest;
use App\Http\Resources\ShoppingCart\ShoppingCartCollection;
use App\Http\Resources\ShoppingCart\ShoppingCartResource;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\ShoppingCart;
use App\Models\Stock;
use Illuminate\Http\JsonResponse;

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

    /**
     * Return all possible errors of amount of products in purchases before finish the shopping
     */
    public function checkAmountErrors(array $content, int $lengthContent) : JsonResponse
    {
        $messages = [];

        for ($i = 0; $i < $lengthContent; $i++) {
            $productId = $content[$i]['productId'];
            $amount = $content[$i]['amount'];

            $product = Product::where('PRODUCT_ID', '=', $productId)->firstOrFail();
            $stock = Stock::where('PRODUCT_ID', '=', $productId)->firstOrFail();

            if ($stock['AMOUNT'] - $amount < 0)
                $messages[] = 'Quantidade indisponível para o produto ' . $product['NAME'];
        }

        return response()->json(['errors' => ['message' => $messages]]);
    }

    /**
     * Finish the shopping cart checking if product exists in stock and return status
     */
    public function finishShoppingCart(FinishShoppingCartRequest $request) : JsonResponse
    {
        $length = count($request->all());

        if ($length == 0)
            return response()->json(['message' => 'Carrinho de compras vazio'])->setStatusCode(400);
        
        $content = $request->all();
        $errors = $this->checkAmountErrors($content, $length);

        if (empty($errors->getContent()))
            return $errors;

        for ($i = 0; $i < $length; $i++) {
            $productId = $content[$i]['productId'];
            $amount = $content[$i]['amount'];
            $stock = null;
            $purchase = null;

            try {
                $stock = Stock::select('AMOUNT')->where('PRODUCT_ID', '=', $productId)->firstOrFail();
                $purchase = Purchase::where('PURCHASE_ID', '=', $content[$i]['purchaseId'])->firstOrFail();

                $request = new UpdateStockRequest([
                    'PRODUCT_ID' => $productId,
                    'AMOUNT' => $stock['AMOUNT'] - $amount
                ]);

                (new StockController)->update($request, $stock);
                (new PurchaseController)->destroy($purchase);
            } catch (\Throwable $th) {
                return response()->json(['message' => 'Compra não realizada'])->setStatusCode(500);
            }
        }

        return response()->json(['message' => 'Compras realizadas com sucesso!'])->setStatusCode(200);
    }
}