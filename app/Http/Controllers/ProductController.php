<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Services\PayUService\Exception;

class ProductController extends Controller
{
    public function getProducts()
    {
        $products = Product::get();
        $result = $this->getAllProductCategories($products);
        return response()->json(['productos:' => $result], 200);
    } 

    public function getProductById(Request $request)
    {
        try {
            $product = Product::findOrFail($request->get('id'));
            $result = $this->getAllProductCategories([$product]);
            return response()->json(['producto encontrado:' => $result], 200);
        } catch(\Exception $e) {
            return response()->json(['No existe el producto'], 422);
        }
    }

    public function createProduct(Request $request) 
    {
        try {
            $product_info = $request->all();
            $product_found = Product::where('titulo', $product_info['titulo'])->first();
            if(!empty($product_found)) {
                return response()->json(['El producto ya existe:' => $product_found], 422);
            }
            $response = Product::create($product_info);
            return response()->json(['Producto creado' => $response], 200);
        } catch(\Exception $e) {
            return response()->json(['error al crear producto:' => $e->getMessage()], 422);
        }
    }

    public function updateProduct(Request $request)
    {
        try {
            $product_info = $request->all();
            $response = Product::findOrFail($product_info['id'])->update($product_info);
            return response()->json(['Producto actualizado' => $response], 200);
        } catch(\Exception $e) {
            return response()->json(['error al actualizar el producto:' => $e->getMessage()], 422);
        }
    }

    public function deleteProduct(Request $request)
    {
        try {
            $response = Product::findOrFail($request->get('id'))->delete();
            return response()->json(['Producto eliminado' => $response], 200);
        } catch(\Exception $e) {
            return response()->json(['error al eliminar el producto:' => $e->getMessage()], 422);
        }
    }

    public function getAllProductCategories($products)
    { 
        $products_with_categories = [];
        foreach($products as $product) {
            $found_categories = Category::whereIn('id',  explode(',', $product['fk_id_categoria']))->get();
            if(!empty($found_categories)) {
                array_push($products_with_categories, [
                    'id' => $product['id'],
                    'titulo' => $product['titulo'],
                    'precio' => $product['precio'],
                    'descripcion' => $product['descripcion'],
                    'categorias' => $found_categories,
                    'created_at' => $product['created_at'],
                    'updated_at' => $product['updated_at'],
                ]);
            }
        }
        return $products_with_categories;
    }
}