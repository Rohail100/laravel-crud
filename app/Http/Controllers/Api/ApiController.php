<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;

class ApiController extends Controller
{
    //create API
    public function createEmployee(Request $request)
    {
        //Validation
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:employees",
            "phone_no" => "required",
            "gender" => "required",
            "age" => "required"
        ]);
        //Create data
        $employee = new Employee();

        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone_no = $request->phone_no;
        $employee->gender = $request->gender;
        $employee->age = $request->age;

        $employee->save();
        //send reponse
        return response()->json([
            "status" => 1,
            "message" => "Employee Created Successfully"
        ]);
    }
    //list API
    public function listEmployees()
    {
        $employees = Employee::get();
        return response()->json([
            "status" => 1,
            "message" => "Employees Listing",
            "employees" => $employees
        ]);
    }
    //getSingle API
    public function getSingleEmployee($id)
    {
        if (Employee::where("id", $id)->exists()) {
            $employee = Employee::where("id", $id)->first();
            return response()->json([
                "status" => 1,
                "message" => "Employee Found",
                "employee" => $employee
            ]);
        } else {
            return response()->json([
                "status" => 0,
                "message" => "Employee not Found",
            ], 404);
        }
    }
    //update API
    public function updateEmployee(Request $request, $id)
    {
        if (Employee::where("id", $id)->exists()) {
            $employee = Employee::find($id);
            $employee->name = !empty($request->name) ? $request->name : $employee->name;
            $employee->email = !empty($request->email) ? $request->email : $employee->email;
            $employee->phone_no = !empty($request->phone_no) ? $request->phone_no : $employee->phone_no;
            $employee->gender = !empty($request->gender) ? $request->gender : $employee->gender;
            $employee->age = !empty($request->age) ? $request->age : $employee->age;
            $employee->save();
            return response()->json([
                "status" => 1,
                "message" => "Employee updated successfully",
            ]);
        } else {
            return response()->json([
                "status" => 0,
                "message" => "Employee not Found",
            ], 404);
        }
    }
    //delete API
    public function deleteEmployee($id)
    {
        if (Employee::where("id", $id)->exists()) {
            $employee = Employee::find($id);
            $employee->delete();
            return response()->json([
                "status" => 1,
                "message" => "Employee deleted successfully",
            ]); 
        } else {
            return response()->json([
                "status" => 0,
                "message" => "Employee not Found",
            ], 404);
        }
    }
}
