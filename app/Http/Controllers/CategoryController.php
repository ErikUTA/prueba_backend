<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function getCategories()
    {
        try {
            $categories = Category::get();
            return response()->json($categories, 200);
        } catch(\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    } 
}
