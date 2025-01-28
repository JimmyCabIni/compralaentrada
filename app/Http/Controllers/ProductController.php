<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        if (!is_null($request['name'])) {
            $query->where('name', 'LIKE', "%{$request['name']}%");
        }

        if (!is_null($request['price'])) {
            $query->where('price', $request['price']);
        }

        $products = $query->paginate(10);

        return response()->json($products, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ]);

        $product = Product::create($validatedData);
        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ]);

        $product->update($validatedData);

        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted'], 200);
    }

    public function assignCategories(Request $request, $id)
    {
        $validated = $request->validate([
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id'
        ]);

        $product = Product::findOrFail($id);

        $product->categories()->sync($validated['category_ids']);

        return response()->json([
            'message' => 'Categories assigned succesfully',
            'product' => $product->load('categories')
        ]);
    }

    public function showDiscount(string $id){
        $product = Product::find($id);
        $priceWithDiscount = $product->getPriceWithDiscount();

        return response()->json([
            'price_with_discount' => $priceWithDiscount
        ]);
    }
}
