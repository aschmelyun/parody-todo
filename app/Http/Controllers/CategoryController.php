<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    
    public function index()
    {
        return Category::with('items')->get();
    }

    public function show(Category $category)
    {
        $category->load('items');

        return $category;
    }

}
