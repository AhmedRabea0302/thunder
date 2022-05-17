<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sector;
use App\Models\Stock;
use App\Models\Product;

class DailyReportController extends Controller
{
    public function index() {
        $sectors = Sector::all();
        $stocks = Stock::all();
        $products = Product::where('product_type', '=', 'نصف مُصنع')->orWhere('product_type', '=', 'تام')->get();
        return view('pages.daily-report.daily-report', [
            'sectors' => $sectors,
            'stocks' => $stocks,
            'products' => $products,
        ]);
    }

    public function getProduct(Request $request) {
        $product = Product::find($request->id);
        $productStandardTreeCost = $product->getProductTrees->where('product_tree_type', '=', '0')->first()->total_budget;
        $productStandardPathCost = $product->getProductPaths->where('path_type', '=', '0')->first()->piece_total_budget;
        $productHasStandardTree = $this->checkIfProductHasStandardProductTree($product->getProductTrees);
        if($product) {
            return response()->json([
                'product' => $product,
                'productHasStTree' => $productHasStandardTree,
                'productStandardTreeCost' => $productStandardTreeCost,
                'productStandardPathCost' => $productStandardPathCost
            ]);
        }
    }

    // Check if the product has a standard Product Tree
    public function checkIfProductHasStandardProductTree($productTrees) {
        $threshold = false;
        foreach($productTrees as $productTree) {
            if($productTree->product_tree_type == '0') {
                $threshold = true;
                break;
            }
        }
        return $threshold;
    }

    public function addDailyReport(Request $request) {

    }
}
