<?php

namespace App\Http\Controllers;

use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();

        return CategoryResource::collection($category);
    }
}
