<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function getCategories()
    {
        $result = Category::get();
        return response()->json(['categorias' => $result], 200);
    } 
}
