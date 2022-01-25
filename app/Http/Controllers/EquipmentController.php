<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use Illuminate\Support\Facades\Validator;

class EquipmentController extends Controller
{
    public function index(Request $request) {
        $equipmentsCount = Equipment::count();
        $equipments = Equipment::when($request->equipment_code, function($query) use ($request) {
            return $query->where('equipment_code', 'like', '%' . $request->equipment_code . '%');
        })->latest()->paginate(10);

        return view('pages.equipments.index', compact('equipments', 'equipmentsCount'));
    }

    public function addEquipment(Request $request) {
        $equipment = new Equipment();

        $rules = [
            'equipment_code' => 'required',
            'workers_number' => 'required',
            'worker_hour_pay' => 'required',
            'equipment_waste' => 'required',
        ];

        $messages = [
            'equipment_code.required' => 'من فضلك أدخل كود المُعدة',
            'workers_number.required' => 'من فضلك أدخل عدد العمال للمُعدة',
            'worker_hour_pay.required' => ' من فضلك أدخل أجر العامل بالساعة',
            'equipment_waste.required' => ' من فضلك أدخل إهلاك المُعدة بالساعة',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
          return response()->json(['messages' => $validator->errors()]);
        }

        $equipment->equipment_code = $request->equipment_code;
        $equipment->workers_number = $request->workers_number;
        $equipment->worker_hour_pay = $request->worker_hour_pay;
        $equipment->waste_per_hour = $request->equipment_waste;
        $equipment->description = $request->description;

        $equipment->save();

        return response()->json(['message' => 'تم إضافة  المُعدة بنجاح!', 'status_code' => '1']);

    }

    public function getEquipment(Request $request) {
        $equipment = Equipment::find($request->id);
        if($equipment) {
            return response()->json($equipment);
        }
    }

    public function updateEquipment(Request $request) {
        $equipment = Equipment::find($request->id);

        $rules = [
            'workers_number' => 'required',
            'equipment_waste' => 'required',
            'worker_hour_pay' => 'required',
        ];

        $messages = [
            'workers_number.required' => 'من فضلك أدخل عدد العمال للمُعدة',
            'worker_hour_pay.required' => ' من فضلك أدخل أجر العامل بالساعة',
            'equipment_waste.required' => ' من فضلك أدخل إهلاك المُعدة بالساعة',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
          return response()->json(['messages' => $validator->errors()]);
        }

        $equipment->workers_number = $request->workers_number;
        $equipment->worker_hour_pay = $request->worker_hour_pay;
        $equipment->waste_per_hour = $request->equipment_waste;
        $equipment->description = $request->description;

        $equipment->save();

        return response()->json(['message' => 'تم تعديل  المُعدة بنجاح!', 'status_code' => '1']);

    }
}
