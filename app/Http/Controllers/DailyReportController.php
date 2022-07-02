<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sector;
use App\Models\Stock;
use App\Models\Product;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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

        $repoertObj = $request->repoertObj;
        $allReportRowsData = $request->allReportRowsData;

        DB::transaction(function () use ($repoertObj, $allReportRowsData) {

            $reportId = DB::table('daily_reports')->insertGetId([
                'sector_id' => $repoertObj['sector'],
                'healthy_stock_delivery_id' => $repoertObj['stock'],
                'corrupt_stock_delivery_id' => $repoertObj['tainted_stock'],
                'shift' => $repoertObj['period'],
                'date' => $repoertObj['date'],
            ]);

            // Insert Report Products
            foreach ($allReportRowsData as $row) {
                DB::table('daily_report_products')->insert([
                    'daily_report_id' => $reportId,
                    'product_id' => $row['product_id'],
                    'quantity' => $row['product_quantity'],
                    'corrupted_quantity' => $row['tainted_product_quantity'],
                    'corrupted_unit' => $row['tainted_unit'],
                    'unit_value' => $row['unit_value'],
                    'total' => $row['total'],
                ]);
                
            }

        });
        Session::flash('message', 'تم إضافة التقرير اليومي بنجاح');
        return response()->json(['code' => '200']);
    }
}
