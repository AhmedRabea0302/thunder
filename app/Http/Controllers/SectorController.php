<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sector;
use Illuminate\Support\Facades\Validator;

class SectorController extends Controller
{
    public function index(Request $request) {
        $sectorsCount = Sector::count();
        $sectors = Sector::when($request->sector_name, function($query) use ($request) {
            return $query->where('name', 'like', '%' . $request->sector_name . '%');
        })->latest()->paginate(10);

        return view('pages.sectors.index', compact('sectors', 'sectorsCount'));
    }

    public function addSector(Request $request) {
        $sector = new sector();

        $rules = [
            'sector_name' => 'required',
        ];

        $messages = [
            'sector_name.required' => 'من فضلك أدخل اسم القسم',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
          return response()->json(['messages' => $validator->errors()]);
        }
        $sector->name = $request->sector_name;

        $sector->save();

        return response()->json(['message' => 'تم إضافة القسم بنجاح!', 'status_code' => '1']);
    }

    public function updateSector(Request $request) {
        $sector = sector::find($request->id);

        $rules = [
            'name' => 'required',
        ];

        $messages = [
            'name.required' => 'من فضلك أدخل اسم القسم',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
          return response()->json(['messages' => $validator->errors()]);
        }
        $sector->name = $request->name;

        $sector->save();

        return response()->json(['message' => 'تم تعديل القسم بنجاح!', 'status_code' => '1']);
    }

    public function deleteSector(Request $request) {

    }

    public function getSector(Request $request) {

    }
}
