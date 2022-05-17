<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    public function index(Request $request) {
        $stocksCount = Stock::count();
        $stocks = Stock::when($request->stock_name, function($query) use ($request) {
            return $query->where('stock_name', 'like', '%' . $request->stock_name . '%');
        })->latest()->paginate(10);

        return view('pages.stocks.index', compact('stocks', 'stocksCount'));
    }

    public function addStock(Request $request) {
        $stock = new Stock();

        $rules = [
            'stock_name' => 'required',
            'stock_code' => 'required',
            'stock_place' => 'required',
            'stock_manager'  => 'required',
        ];

        $messages = [
            'stock_name.required' => 'من فضلك أدخل اسم المخزن',
            'stock_code.required' => 'من فضلك أدخل كود المخزن',
            'stock_place.required' => 'من فضلك أدخل مكان المخزن',
            'stock_manager.required' => 'من فضلك أدخل أمين المخزن',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
          return response()->json(['messages' => $validator->errors()]);
        }

        $stock->stock_name = $request->stock_name;
        $stock->stock_code = $request->stock_code;
        $stock->stock_place = $request->stock_place;
        $stock->stock_manager = $request->stock_manager;

        $stock->save();

        return response()->json(['message' => 'تم إضافة المخزن بنجاح!', 'status_code' => '1']);
    }

    public function updateStock(Request $request) {
        $stock = Stock::find($request->id);

        $rules = [
            'stock_name' => 'required',
            'stock_place' => 'required',
            'stock_manager'  => 'required',
        ];

        $messages = [
            'stock_name.required' => 'من فضلك أدخل اسم المخزن',
            'stock_place.required' => 'من فضلك أدخل مكان المخزن',
            'stock_manager.required' => 'من فضلك أدخل أمين المخزن',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
          return response()->json(['messages' => $validator->errors()]);
        }

        $stock->stock_name = $request->stock_name;
        $stock->stock_place = $request->stock_place;
        $stock->stock_manager = $request->stock_manager;

        $stock->save();

        return response()->json(['message' => 'تم تعديل  المخزن بنجاح!', 'status_code' => '1']);
    }

    public function deleteSector(Request $request) {

    }

    public function getSector(Request $request) {

    }
}
