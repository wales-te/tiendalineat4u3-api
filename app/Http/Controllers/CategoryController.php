<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // ✅ Listar categorías (GET /api/categories)
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();

        return response()->json([
            'status' => 'success',
            'total' => $categories->count(),
            'data' => $categories,
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    // ✅ Crear categoría (POST /api/categories)
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
        ]);

        $category = Category::create($data);

        return response()->json([
            'status' => 'created',
            'message' => 'Categoría creada correctamente.',
            'data' => $category,
        ], 201, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    // ✅ Mostrar una categoría (GET /api/categories/{id})
    public function show(Category $category)
    {
        return response()->json([
            'status' => 'success',
            'data' => $category,
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    // ✅ Actualizar categoría (PUT /api/categories/{id})
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'slug' => 'sometimes|string|max:255|unique:categories,slug,' . $category->id,
        ]);

        $category->update($data);

        return response()->json([
            'status' => 'updated',
            'message' => 'Categoría actualizada correctamente.',
            'data' => $category,
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    // ✅ Eliminar categoría (DELETE /api/categories/{id})
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'status' => 'deleted',
            'message' => 'Categoría eliminada correctamente.',
        ], 204, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
