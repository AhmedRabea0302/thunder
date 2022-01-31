<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sector;
use App\Models\Equipment;
use App\Models\Product;

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
}
