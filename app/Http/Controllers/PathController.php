<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sector;
use App\Models\Equipment;
use App\Models\Product;
use App\Models\Path;
use App\Models\PathStep;
use App\Models\PathExpense;

use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\DB;


class PathController extends Controller
{
    public function index(Request $request) {
        $paths = Path::OrderBy('created_at', 'DESC')->paginate(10);
        return view('pages.paths.index', compact('paths'));
    }

    public function getAddPath() {
        $sectors = Sector::all();
        $equipments = Equipment::all();
        $products = Product::where('product_type', '=', 'نصف مُصنع')->orWhere('product_type', '=', 'تام')->get();
        return view('pages.paths.add-path', compact('sectors', 'equipments', 'products'));
    }

    public function addPath(Request $request) {

        $pathData = $request->pathData;
        $pathSteps = $request->pathSteps;
        $pathExpenses = $request->pathExpenses;

        DB::transaction(function () use ($pathData, $pathSteps, $pathExpenses) {

            $pathId = DB::table('paths')->insertGetId([
                'sector_id' => $pathData['pathSector'],
                'product_id' => $pathData['productPicker'],
                'path_code' => $pathData['pathCode'],
                'path_type' => $pathData['pathType'],
                'path_quantity' => $pathData['quantity'],
                'piece_total_budget' => $pathData['totalBudget'],
            ]);

            // Inser Path Steps
            foreach ($pathSteps as $step) {
                $type = $step['stepType'];
                if($type == 'يدوي') {
                    DB::table('path_steps')->insert([
                        'path_id' => $pathId,
                        'equipment_id' => $step['equipmentId'],
                        'step_type' => $step['stepType'],
                        'workers_number' => $step['workersNumber'],
                        'worker_hour_pay' => $step['workerPay'],
                        'production_time_rate' => $step['productionRate'],
                        'step_total_budget' => $step['stepTotalBudget'],
                    ]);
                } else {
                    $equipmentId = (int)$step['equipmentId'];
                    $equipment = Equipment::find($equipmentId);

                    if($equipment) {
                        DB::table('path_steps')->insert([
                            'path_id' => $pathId,
                            'equipment_id' => $equipment->id,
                            'step_type' => $step['stepType'],
                            'workers_number' => $equipment->workers_number,
                            'worker_hour_pay' => $equipment->worker_hour_pay,
                            'production_time_rate' => $step['productionRate'],
                            'step_total_budget' => $step['stepTotalBudget'],
                        ]);
                    }
                }
            }

            // Insert Expenses
            foreach ($pathExpenses as $expense) {
                DB::table('path_expenses')->insert([
                    'path_id' => $pathId,
                    'equipment_id' => $expense['expenseId'],
                    'expense_type' => $expense['expenseType'],
                    'expense_value' => $expense['expenseValue'],
                ]);
            }

        });
        Session::flash('message', 'تم إضافة المسار بنجاح');
        return response()->json(['code' => '200']);

    }

    public function getPathDetails(Request $request, $id) {
        $sectors = Sector::all();
        $equipments = Equipment::all();
        $products = Product::where('product_type', '=', 'نصف مُصنع')->orWhere('product_type', '=', 'تام')->get();

        $path = Path::find($id);
        $pathSteps = PathStep::where('path_id', $id)->get();
        $pathExpenses = PathExpense::where('path_id', $id)->get();

        return view('pages.paths.path-details',
        compact('path', 'pathSteps', 'pathExpenses', 'sectors', 'equipments', 'products'));
    }

    public function updatePath(Request $request) {

    }

    public function getPathExpenses(Request $request, $id) {
        $expenses = PAthExpense::where('path_id', $id)->get();
        $tempArray = [];
        foreach ($expenses as $expense) {
            $object = (object) array(
                'id'    => $expense->id,
                'expenseId'    => $expense->equipment_id,
                'expenseType'    => $expense->expense_type,
                'expenseValue'    => $expense->expense_value,
            );
            array_push($tempArray, $object);
        }
        return response()->json($tempArray);
    }

    // Check if the product has a standard path or not
    public function checkProductStandardPath(Request $request) {
        $threshold = false;
        $product_paths = Path::where('product_id', '=', $request->id)->get();
        foreach($product_paths as $product_path) {
            if($product_path->path_type == '0') {
                $threshold = true;
                break;
            }
        }
        return $threshold;
    }
}
