<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyReport;
use App\Models\DailyReportProduct;
use App\Models\Product;
use App\Models\ProductTree;
use App\Models\TreeProduct;
use App\Models\Path;
use App\Models\PathStep;
use App\Models\PathExpense;

class ReportController extends Controller
{
    public function productsOfDay() {
        return view('pages.reports.daily_report');
    }

    public function printProductsOfDay(Request $request) {
        $daily_reports = DailyReport::where('date', $request->date)->with('getDailyReportProducts')->get();
        // $daily_report_products = [];
        // if($daily_reports) {
        //     foreach($daily_reports as $report) {
                
        //         array_push($daily_report_products, DailyReportProduct::where('daily_report_id', $report->id)->get());
        //     }  
        // }
        
        return view('pages.reports.print_daily_report', [
            'daily_reports' => $daily_reports,
            'date' => $request->date
        ]); 
    }

    public function productsOfTree() {
        $product_trees = ProductTree::all();
        return view('pages.reports.product_tree', ['product_trees' => $product_trees]);
    }

    public function PrintProductsOfTree(Request $request) {
        $product_tree = ProductTree::find($request->product_tree);
        if($product_tree) {
            $tree_products = TreeProduct::where('product_tree_id', $product_tree->id)->get();
        }
        
        return view('pages.reports.print_product_tree', ['product_tree' => $product_tree, 'tree_products' => $tree_products]);
    }

    public function pathSteps() {
        $paths = Path::all();
        return view('pages.reports.paths', ['paths' => $paths]);
    }

    public function printPathDetails(Request $request) {
        $path = Path::find($request->path);
        if($path) {
            $path_steps = PathStep::where('path_id', $path->id)->get();
            $path_expenses = PathExpense::where('path_id', $path->id)->get();
        }
        
        return view('pages.reports.print_paths', ['path' => $path, 'path_steps' => $path_steps, 'path_expenses' => $path_expenses]);
    }
}
