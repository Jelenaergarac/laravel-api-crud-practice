<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function createEmployee(Request $request){

        $request->validate([
            'name' => 'required',
            'email'  => 'required|email|unique:employees',
            'phone_no'  => 'required',
            'gender'  => 'required' ,
            'age'  => 'required'
        ]);
        $employee = new Employee();
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone_no = $request->phone_no;
        $employee->gender = $request->gender;
        $employee->age = $request->age;
        $employee->save();

        return response()->json([
            'status'=>1,
            'message'=>'Created successfully'
        ]);



    }

    public function listEmployees(){
        $employees = Employee::get();

      return response()->json($employees);
    }

    public function getSingleEmployee($id){

        if(Employee::where('id', $id)->exists()){
 
            $employeeDetails = Employee::where('id', $id)->first();

            return response()->json([
                'status'=>1,
                'message'=>'Employee found',
                'data'=>$employeeDetails
            ]);
        }else{
            return response()->json([
                'status'=>0,
                'message'=>'Employee not found'
            ],404);
        }

    }

    public function updateEmployee(Request $request, $id){


        if(Employee::where('id', $id)->exists()){
            $employee = Employee::find($id);
            $employee->name = !empty( $request->name) ? $request->name : $employee->name;
            $employee->email = !empty($request->email) ? $request->email : $employee->email;
            $employee->phone_no = !empty($request->phone_no) ? $request->phone_no : $employee->phone_no;
            $employee->gender =!empty( $request->gender) ? $request->gender : $employee->gender;
            $employee->age = !empty($request->age) ? $request->age : $employee->age;
        $employee->save();
        
            return response()->json([
            'status'=>1,
            'message'=>'Employee updated successfully!'
        ]);
        
        }else{
            return response()->json([
                'status'=>0,
                'message'=>'Employee not found'
            ],404);
        }

    }
    public function deleteEmployee($id){

        if(Employee::where('id', $id)->exists()){

            $employee = Employee::find($id);
            $employee->delete();
            return response()->json([
                'status'=>1,
                'message'=>"Employee deleted successfully"
            ]);
        }else{
             return response()->json([
                'status'=>0,
                'message'=>'Employee not found'
            ],404);

        }
    }
}
