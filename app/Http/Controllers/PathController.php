<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sector;
use App\Models\Equipment;
use App\Models\Product;
use App\Models\Path;
use App\Models\PathStep;

use Illuminate\Support\Facades\DB;


class PathController extends Controller
{
    public function index(Request $request) {
        $paths = [];
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
        // dd($pathData['pathSector']);
        $pathSteps = $request->pathSteps;
        $pathExpense = $request->pathExpenses;

        DB::transaction(function () use ($pathData, $pathSteps, $pathExpense) {

            $pathId = DB::table('paths')->insertGetId([
                'sector_id' => $pathData['pathSector'],
                'product_id' => $pathData['productPicker'],
                'path_code' => $pathData['pathCode'],
                'path_type' => $pathData['pathType'],
                'path_quantity' => $pathData['quantity'],
                'piece_total_budget' => $pathData['totalBudget'],
            ]);

            foreach ($pathSteps as $step) {
                $type = $step['stepType'];
                if($type == 'manually') {

                } else {

                }
            }

        });
    }
}
