<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{

    public function index() {
        $all_categories = Category::whereCatParent(0)->paginate(5);
        $title = 'أقسام الاختبارات';
        return view('categories.index', compact('all_categories', 'title'));
    }

    public function show(Category $category) {
        $title = $category->cat_name;
        if($category->is_parent()){
            return view('categories.index', compact('category', 'title'));
        }

        return view('categories.show', compact('category', 'title'));
    }
}
