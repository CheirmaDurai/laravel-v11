<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as HTTPRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;

class HomeController extends Controller
{
    public function index(HTTPRequest $request)
    {
        if (Auth::check()) {
            $user = $request->user();
        } else {
            $user = [];
        }
        return response()->json(['User' => $user, 'data' => Employee::all()]);
    }

    public function store(Request $request)
    {
        $employee = Employee::create(
            [
                'name' => Request::post('name'),//'Raja ' . time(),
            ]
        );
        return response()->json($employee);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);
        #$employeeOld = $employee->$request->toArray();
        $employee = $employee->update(
            [
                'name' => Request::post('name'),
            ]
        );
        return response()->json($employee);
    }

    public function destroy(Request $request)
    {
        //print_r(Request::all());
        return 'DELETE request';
    }
}
