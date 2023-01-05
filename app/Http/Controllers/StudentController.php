<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Validator;
class StudentController extends Controller
{

    public function index(){
        $data['students'] = Student::all();
        return response()->json($data, 200);
    }
    public function store(Request $req){
        $data = Validator::make($req->all(),[
            'name' => 'required',
            'contact' => 'required',
            'email' => 'required',
            'city' => 'required',
        ]);

        if($data->fails()){
            return response()->json(["status" => false,"msg" => $data->errors()], 200);
        }
        else{
            $insertData =  Student::create($data->validated());
            return response()->json([
                "status" => true,
                "msg" => "data Inserted Successfully", 
                "insertedData"  => $insertData
            ], 200);
        }
    }

    public function deleteStudent(Student $std){
        $std->delete($std->id);
       $context['data'] =  $std;
       $context['status'] = true;
       $context['msg'] = "Data deleted successfully";


        return response()->json($context, 200);
    }

    public function updateStudent(Student $std, Request $req){
        $data = Validator::make($req->all(),[
            'name' => 'required',
            'contact' => 'required',
            'email' => 'required',
            'city' => 'required',
        ]);

        if($data->fails()){
            return response()->json(["status" => false,"msg" => $data->errors()], 200);
        }
        else{
            $std->name = $req->name;
            $std->email = $req->email;
            $std->contact = $req->contact;
            $std->city = $req->city;
            $std->save();
            return response()->json([
                "status" => true,
                "msg" => "data Updated Successfully", 
                "updatedData"  => $std
            ], 200);
        }

    }
}