<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Path;
use App\Models\ProductTree;

use Illuminate\Http\Request;

class StandardCostController extends Controller
{
    public function index() {
        $products = Product::where('product_type', '=', 'نصف مُصنع')->orWhere('product_type', '=', 'تام')->get();
        return view('pages.standard-cost.index', ['products' => $products]);
    }

    public function getProductPathsAndTrees(Request $request) {

        $prodcut_id = $request->id;

        if($prodcut_id) {
            $paths = Path::where('product_id', $prodcut_id)->with('getPathSteps')->get();
            $trees = ProductTree::where('product_id', $prodcut_id)->get();
        }
        return response()->json(['paths' => $paths, 'trees' => $trees]);
    }

}
