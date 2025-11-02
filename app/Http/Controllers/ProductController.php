<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // ✅ Listar productos (GET /api/products?q=texto)
    public function index(Request $request)
    {
        $q = $request->query('q');
        $query = Product::with('category')->latest();

        if ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%$q%")
                    ->orWhere('sku', 'like', "%$q%");
            });
        }

        return $query->paginate(10);
    }

    // ✅ Crear producto (POST /api/products)
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = Product::create($data);

        return response()->json($product->load('category'), 201);
    }

    // ✅ Ver un producto (GET /api/products/{product})
    public function show(Product $product)
    {
        return $product->load('category');
    }

    // ✅ Actualizar producto (PUT/PATCH /api/products/{product})
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'sku' => 'sometimes|string|max:100|unique:products,sku,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'category_id' => 'sometimes|exists:categories,id',
        ]);

        $product->update($data);

        return $product->load('category');
    }

    // ✅ Eliminar producto (DELETE /api/products/{product})
    public function destroy(Product $product)
    {
        $product->delete(); // 👈 faltaba este ';'
        return response()->noContent();
    }
}
