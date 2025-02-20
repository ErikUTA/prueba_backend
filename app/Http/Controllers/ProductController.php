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
            $categories = Category::get();
            return response()->json([
                'products' => $products,
                'categories' => $categories
            ], 200);
        } catch(\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getProductById(Request $request)
    {
        try {
            $product = Product::with('categories')->whereId($request->get('id'))->first();       
            if(empty($product)) {
                return response()->json(['message' => 'No existe el producto'], 500);
            }   
            return response()->json($product, 200);
        } catch(\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function createProduct(Request $request) 
    {
        try {
            \DB::beginTransaction();
            $input = $request->all();
            $product = Product::create($input);
            if(!empty($input['categories'])) {
                $product->categories()->attach($input['categories']);
            }
            
            \DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Producto creado correctamente',
                'product' => $product
            ], 200);
        } catch(\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ], 500);          
        }
    }

    public function updateProduct(Request $request)
    {
        try {
            \DB::beginTransaction();
            $input = $request->all();
            $product = Product::findOrFail($input['id']);
            $product->categories()->detach();
            if(!empty($input['categories'])) {
                $product->categories()->attach($input['categories']);
            }
            $product->update($input);
            
            \DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Producto actualizado correctamente',
                'product' => $product
            ], 200);
        } catch(\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ], 500);        
        }
    }

    public function deleteProduct(Request $request)
    {
        try {
            $product = Product::findOrFail($request->get('id'));
            $product->categories()->detach();
            $product->delete($product->id);
            return response()->json([
                'success' => true,
                'message' => 'Producto eliminado correctamente'
            ], 200);
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ], 500);
        }
    }
}