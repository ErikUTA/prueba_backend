<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductHasCategory;
use App\Services\PayUService\Exception;

class ProductController extends Controller
{
    public function getProducts()
    {
        try {
            $products = Product::with('categories')->get();
            return response()->json($products, 200);
        } catch(\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    } 

    public function getProductById(Request $request)
    {
        try {
            $product = Product::with('categories')->whereId($request->get('id'))->first();       
            if(empty($product)) {
                return response()->json(['message' => 'No existe el producto'], 422);
            }   
            return response()->json($product, 200);
        } catch(\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function createProduct(Request $request) 
    {
        try {
            $data = $request->all();
            $categoryIds = explode(',', $request->get('categories'));
            $product = Product::create($data);
            $product->categories()->attach($categoryIds);
            
            return response()->json([
                'message' => 'Producto creado correctamente',
                'product' => $product
            ], 200);
        } catch(\Exception $e) {
            return response()->json(['Error al crear producto' => $e->getMessage()], 422);
        }
    }

    public function updateProduct(Request $request)
    {
        try {
            $data = $request->all();
            $product = Product::findOrFail($data['id']);
            $categoryIds = explode(',', $data['categories']);
            
            $product->categories()->detach();
            $product->categories()->attach($categoryIds);
            $product->update($data);
            
            return response()->json(['Producto actualizado correctamente' => $product], 200);
        } catch(\Exception $e) {
            return response()->json(['Error al actualizar el producto' => $e->getMessage()], 422);
        }
    }

    public function deleteProduct(Request $request)
    {
        try {
            $product = Product::findOrFail($request->get('id'));
            $product->categories()->detach();
            $product->delete($product->id);
            return response()->json([
                'message' => 'Producto eliminado correctamente'
            ], 200);
        } catch(\Exception $e) {
            return response()->json(['Error al eliminar el producto' => $e->getMessage()], 422);
        }
    }
}