<?php

namespace App\Services;

//facades
use Illuminate\Support\Facades\Auth; 

//models
use App\Models\Category;

class CategoryService {
    public function getAllCategories() {
        return response()->json(Category::select('id', 'category')->get())->original;
    }
}
