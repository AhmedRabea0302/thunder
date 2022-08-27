<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request) {
        $productsCount = Product::count();
        $products = Product::when($request->product_code, function($query) use ($request) {
            return $query->where('product_code', 'like', '%' . $request->product_code . '%');
        })->latest()->paginate(10);
        return view('pages.products.index', ['products' => $products, 'productsCount' => $productsCount]);
    }

    public function getProduct(Request $request) {
        $product = Product::find($request->id);
        if($product) {
            return response()->json($product);
        }
    }
    public function addProduct(Request $request) {
        $product = new Product();

        $rules = [
            'product_code' => 'required|unique:products|min:8|max:16',
            'product_type' => 'required',
            'unit' => 'required',
            'description' => 'required',
        ];

        $messages = [
            'product_code.required' => 'من فضلك أدخل كود المُنتج',
            'product_code.unique' => 'لا يمكن إضافة هذا الكود، تم إضافته من قبل',
            'product_code.min' => 'كود المنتج يجب أن يكون أكثر من 8 حروف وأرقام',
            'product_code.max' => 'كود المنتج لايمكن أن يتعدى 16 حرف',
            'product_type.required' => 'من فضلك إختر نوع المُنتج',
            'unit.required' => 'من فضلك أدخل الوحدة',
            'description.required' => ' من فضلك أدخل وصف المُنتج',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
          return response()->json(['messages' => $validator->errors()]);
        }

        $product->product_code = $request->product_code;
        $product->product_type = $request->product_type;
        $product->unit = $request->unit;
        $product->unit_value = $request->unit_value;
        $product->description = $request->description;

        $product->save();

        return response()->json(['message' => 'تم إضافة المُنتج بنجاح!', 'status_code' => '1']);
    }

    public function updateProduct(Request $request) {
        $product = Product::find($request->id);

        $rules = [
            'product_type' => 'required',
            'unit' => 'required',
            'description' => 'required',
        ];

        $messages = [
            'product_type.required' => 'من فضلك إختر نوع المُنتج',
            'unit.required' => 'من فضلك أدخل الوحدة',
            'description.required' => ' من فضلك أدخل وصف المُنتج',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
          return response()->json(['messages' => $validator->errors()]);
        }

        $product->product_type = $request->product_type;
        $product->unit = $request->unit;
        $product->unit_value = $request->unit_value;
        $product->description = $request->description;

        $product->save();

        return response()->json(['message' => 'تم تعديل المُنتج بنجاح!', 'status_code' => '1']);
    }

}
