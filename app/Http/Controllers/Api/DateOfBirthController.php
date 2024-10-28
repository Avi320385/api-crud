<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DateResource;
use App\Models\DateOfBirth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DateOfBirthController extends Controller
{
    public function index()
    {
       $date = DateOfBirth::get();
       if($date->count()>0)
       {
          return DateResource::collection($date);
       }
       else
       {
           return response()->json(['message'=>'Nothing to show'],200);
       }
    }
    public function store(Request $request)
    {


        $validator=Validator::make($request->all(),[

                            'date_of_birth'=> 'required|date',

                        ]);
         if($validator->fails())
         {
            return response()->json([
              'message'=>'all field are mandatory',
              'error'=>$validator->messages(),
            ],422);
         }
      $date= DateOfBirth::create([
         'date_of_birth'=> $request->date_of_birth,

       ]);
       return response()->json([
           'message'=>'date created Successfully',
           'data'=> new DateResource($date)
       ],200);
    }
}
