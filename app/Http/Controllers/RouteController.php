<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Record;
use Carbon\Carbon;
use App\TimeNode;


class RouteController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function valid() {
        $employees = Employee::orderBy('work_number')->paginate(15);
        
        return view('valid', [
            'employees' => $employees,
        ]);
    }

    public function valid_date(Request $request) {
        $date = $request->input('date');

        $employees = Employee::orderBy('work_number')->paginate(15);

        return view('valid_date', [
            'employees' => $employees,
            'date' => $date,
        ]);
    }

    public function graph() {
        return view('graph');
    }

    // public function correct() {
    //     return view('correct');
    // }

    public function report() {
        return view('report');
    }

    public function holiday() {
        return view('holiday');
    }

    public function timeedit() {
        $timenodes = TimeNode::all();

        return view('timeedit', [
            'timenodes' => $timenodes,
        ]);
    }
}
