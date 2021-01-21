<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::paginate(env('PAGINATION_COUNT'));
        return view('admin.categories.categories')->with([
            'categories' => $categories,
            'showLinks' => true
        ]);
    }

    private function isCategoryNameExists($categoryName) {
        $category = Category::where('name', '=' , $categoryName)->first();
        if ($category) {
            Session::flash('error' , 'Category name ' . $category->name . ' already exists');
            return false;
        }
        return true;
    }

    public function store(Request $request) {
        $request->validate([
            'category_name' => 'required'
        ]);

        $categoryName = $request->input('category_name');

        if (!$this->isCategoryNameExists($categoryName)) {
            return redirect()->back();
        }

        $category = new Category();
        $category->name = $categoryName;
        $category->save();

        return redirect()->back()->with('success' , 'Category ' . $category->name . ' has been added successfully');
    }

    public function delete(Request $request){
        $id = $request->input('category_id');
        Category::destroy($id);
        return redirect()->back()->with('success' , 'Category has been deleted successfully');
    }

    public function update(Request $request){
        $request->validate([
            'category_name' => 'required'
        ]);

        $categoryName = $request->input('category_name');

        if (!$this->isCategoryNameExists($categoryName)){
            return redirect()->back();
        }

        $id = $request->input('category_id');
        $category = Category::find($id);
        $category->name = $categoryName;
        $category->save();
        return redirect()->back()->with('success', 'Category ' . $category->name . ' has been updated successfully');
    }

    public function search(Request $request){
        $request->validate([
            'category_search' => 'required'
        ]);

        $searchTerm = $request->input('category_search');

        $categories = Category::where('name', 'LIKE' , '%' . $searchTerm . '%')->get();
        if (count($categories) > 0){
            return view('admin.categories.categories')->with([
                'categories' => $categories,
                'showLinks' => false
            ]);
        }
       return redirect()->back()->with('warning' , 'Sorry nothing found');
    }
}
