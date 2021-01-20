<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class UnitController extends Controller
{

    public function index() {
        $units = Unit::paginate(env('PAGINATION_COUNT'));
        return view('admin.units.units')->with(['units' => $units]);
    }

    private function isUnitNameExists($unitName) {
        $unit = Unit::where(
            'unit_name', '=', $unitName
        )->first();
        if ($unit) {
            Session::flash('error', 'Unit name ('. $unitName .') is already exists');
            return false;
        }
        return true;
    }

    private function isUnitCodeExists($unitCode) {
        $unit = Unit::where(
            'unit_code', '=', $unitCode
        )->first();
        if ($unit) {
            Session::flash('error', 'Unit code ('. $unitCode .') is already exists');
            return false;
        }
        return true;
    }

    public function store(Request $request) {
        $request->validate([
            'unit_name' => 'required',
            'unit_code' => 'required'
        ]);

        $unitName = $request->input('unit_name');
        $unitCode = $request->input('unit_code');

        if (!$this->isUnitNameExists($unitName)) {
            return redirect()->back();
        }

        if (!$this->isUnitCodeExists($unitCode)) {
            return redirect()->back();
        }

        $unit = new Unit();

        $unit->unit_name = $request->input('unit_name');
        $unit->unit_code = $request->input('unit_code');
        $unit->save();

        return redirect()->back()->with('message', 'Unit ' . $unit->unit_name . ' Has been added ');
    }

    public function delete(Request $request) {
        $id = $request->input('unit_id');

        if (is_null($request->input('unit_id')) || empty($request->input('unit_id'))){
            return redirect()->back()->with('error', 'Unit Id is required');
        }
        Unit::destroy($id);
        return redirect()->back()->with('message', 'Unit has been deleted');
    }

    public function update(Request $request){
        $request->validate([
            'unit_name' => 'required',
            'unit_code' => 'required',
            'unit_id' => 'required'
        ]);

        $unitName = $request->input('unit_name');
        $unitCode = $request->input('unit_code');

        if (!$this->isUnitNameExists($unitName)) {
            return redirect()->back();
        }

        if (!$this->isUnitCodeExists($unitCode)) {
            return redirect()->back();
        }

        $unitID = intval($request->input('unit_id'));
        $unit = Unit::find($unitID);
        $unit->unit_name = $request->input('unit_name');
        $unit->unit_code = $request->input('unit_code');
        $unit->save();

        return redirect()->back()->with('message', 'Unit '. $unit->unit_name . ' has been updated');

    }


}
