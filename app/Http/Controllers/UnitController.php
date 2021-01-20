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

    public function store(Request $request) {
        $request->validate([
            'unit_name' => 'required',
            'unit_code' => 'required'
        ]);

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

        $unitID = intval($request->input('unit_id'));
        $unit = Unit::find($unitID);
        $unit->unit_name = $request->input('unit_name');
        $unit->unit_code = $request->input('unit_code');
        $unit->save();

        return redirect()->back()->with('message', 'Unit '. $unit->unit_name . ' has been updated');

    }


}
