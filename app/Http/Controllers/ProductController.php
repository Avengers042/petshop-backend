<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::all();

        if (! empty($request->query('page'))) {
            $page = $request->query('page') || 1;
            $totalPerPage = 10;

            if (!empty($request->query('totalPerPage')))
                $totalPerPage = $request->query('totalPerPage');

            $products = Product::all()->forPage($page, $totalPerPage);
        }



        return response()->json(new ProductCollection($products));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        return response()->json(new ProductResource(Product::create($request->all())))->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json(new ProductResource($product));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        return response()->json(new ProductResource(tap($product)->update($request->all())));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        return response()->json(new ProductResource(tap($product)->delete()));
    }
}