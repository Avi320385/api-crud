<?php

namespace App\Http\Controllers\Api;

use App\Models\Info;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\InfoResource;
use Illuminate\Support\Facades\Validator;

class InfoController extends Controller
{
    public function index()
    {
        $info = Info::get();
        if($info->count()>0)
        {
           return InfoResource::collection($info);
        }
    }
    public function store(Request $request)
    {

        $validator=Validator::make($request->all(),[
                            'name'=> 'required|string|max:255',
                            'email'=> 'required|email',
                            'password'         => 'required',
                           // 'password_confirm' => 'required|same:password',
                            'phone' => 'required|integer',
                            'adress' => 'required|string',
                            'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
                            'date_of_birth' => 'required|date',

                        ]);
         if($validator->fails())
         {
            return response()->json([
              'message'=>'all field are mandatory',
              'error'=>$validator->messages(),
            ],422);
         }
       Info::create([
         'name'=> $request->name,
        'email'=> $request->email,
        'password'=> $request->password,
        //'password_confirm'=> $request->password_confirm,
        'phone'=> $request->phone,
        'adress'=> $request->adress,
        'date_of_birth'=> $request->date_of_birth,

        'image'=>  $request->file('image'),

       ]);
       $image = $request->file('image');

       // Create a unique name for the image
       $imageName = time() . '.' . $image->getClientOriginalExtension();

       // Create the directory path based on user's email
       $directory = public_path($request->email);

       // Create the directory if it does not exist
       if (!file_exists($directory)) {
           mkdir($directory, 0777, true);
       }

       // Move the image to the user's email folder
       $image->move($directory, $imageName);

       return response()->json(['success' => ' yes yes i can do it']);

      // $imageName = time().'.'.request()->image->getClientOriginalExtension();
       //$path = "public/".$request->email."imageName";
       //request()->image->move(public_path('$request->email'), $imageName);
       //request()->image->move(public_path('\public\$request->email'), $imageName);
      //request()-> move_uploaded_file($imageName, '$request->email/' . $imageName);
    //    return response()->json([
    //        'message'=>'Product created Successfully',
    //        'data'=> new ProductResource($product)
    //    ],200);
    }
}
