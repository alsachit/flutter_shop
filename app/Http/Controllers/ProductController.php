<?php

namespace App\Http\Controllers;

use App\Category;
use App\Image;
use App\Product;
use App\Unit;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        $products = Product::with(['category', 'images', 'hasUnit'])->paginate(env('PAGINATION_COUNT'));
        $currency_code = env('CURRENCY_CODE', '$');
        return view('admin.products.products')->with(
            [
                'products' => $products,
                'currency_code' => $currency_code
            ]
        );
    }

    /**
     * @param Request $request
     * @param Product $product
     */

    private function writeProduct(Request $request, Product $product, $update = false) {
        $product->title = $request->input('product_title');
        $product->description = $request->input('product_description');
        $product->category_id = $request->input('product_category');
        $product->unit = $request->input('product_unit');
        $product->price = $request->input('product_price');
        $product->discount = $request->input('product_discount');
        $product->total = $request->input('product_total');

        if ($request->has('options')){
            $optionArray = [];
            $options = array_unique($request->input('options'));

            foreach ($options as $option){
                $actualOptions = $request->input($option);
                $optionArray[$option] = [];
                foreach ($actualOptions as $actualOption ) {
                    array_push($optionArray[$option], $actualOption);
                }
            }

            $product->options = json_encode($optionArray);
        }


        $product->save();

        if ($request->hasFile('product_images')){
            $images = $request->file('product_images');
            foreach ($images as $image){
                $path = $image->store('images', 'public');
                $image = new Image();
                $image->url = 'storage/'.$path;
                $image->product_id = $product->id;
                $image->save();
            }
        }
    }

    public function store(Request $request) {

        $request->validate([
            'product_title' => 'required',
            'product_description' => 'required',
            'product_category' => 'required',
            'product_unit' => 'required',
            'product_price' => 'required',
            'product_discount' => 'required',
            'product_total' => 'required'
        ]);

        $product = new Product();

        $this->writeProduct($request, $product);

        return redirect('products')->with('success', 'Product has been added successfully');
     }

    public function newProduct($id = null) {

        $product = null;

        if (!is_null($id)) {
            $product = Product::with([
                'hasUnit',
                'category',
                'images'
            ])->find($id);
        }

        $units = Unit::all();
        $categories = Category::all();

        return view('admin.products.new-product')->with([
            'product' => $product,
            'units' => $units,
            'categories' => $categories,

        ]);
    }

    public function delete(Request $request, $id) {

    }

    public function update(Request $request) {
        $request->validate([
            'product_title' => 'required',
            'product_description' => 'required',
            'product_category' => 'required',
            'product_unit' => 'required',
            'product_price' => 'required',
            'product_discount' => 'required',
            'product_total' => 'required'
        ]);

        $product_id = $request->input('product_id');

        $product = Product::find($product_id);

        $this->writeProduct($request, $product, true);

        return back();
    }

    public function search(Request $request) {

    }


    public function deleteImage(Request $request){
        $imageId = $request->input('image_id');
        Image::destroy($imageId);
    }




}
