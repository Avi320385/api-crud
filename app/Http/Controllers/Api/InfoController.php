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
                            'image' => 'mimes:jpeg,jpg,png,gif,avif|required|max:10000',
                            'date_of_birth' => 'required|date',

                        ]);
                        $info = Info::create([
                            'name' => $request->name,
                            'email' => $request->email,
                            'password' => bcrypt($request->password),
                            'phone' => $request->phone,
                            'adress' => $request->adress,
                            'date_of_birth' => $request->date_of_birth,
                            // Save image field empty for now; it will be updated shortly
                            'image' => '',
                        ]);

                        // Generate the image directory based on the database record's name or id
                        $image = $request->file('image');
                        $originalName = $image->getClientOriginalName();
                        $imageDirectory = public_path($info->email);
                        $imageName = '/public' .'/'. $info->email.'/'.$originalName;

                        // Create the directory if it doesn't exist
                        if (!file_exists($imageDirectory)) {
                            mkdir($imageDirectory, 0777, true);
                        }

                        // Move the image to the created directory
                        $image->move($imageDirectory, $imageName);

                        // Update the record with the image path
                        $info->update([
                            'image' => $imageName,
                        ]);

                        return new InfoResource($info);

                        // return response()->json(
                        //     [
                        //         'id'=>$request->id,
                        //         'name'=>$request->name,
                        //         'email'=>$request->email,
                        //         'password'=>$request->password,
                        //         'phone'=>$request->phone,
                        //         'adress'=>$request->adress,
                        //         'date_of_birth'=>$request->date_of_birth,
                        //         'image'=>$request->image,

                        //     ],);
    //      if($validator->fails())
    //      {
    //         return response()->json([
    //           'message'=>'all field are mandatory',
    //           'error'=>$validator->messages(),
    //         ],422);
    //      }


    //    // Create a unique name for the image


    //    // Create the directory path based on user's email
    //    $image = $request->file('image');
    //    //$originalName = $image->getClientOriginalName();
    //    $directory = public_path($request->email);
    //    $imageName = $request->email . '_' . time() ;

    //    // Create the directory if it does not exist
    //    if (!file_exists($directory)) {
    //        mkdir($directory, 0777, true);
    //    }

    //    // Move the image to the user's email folder
    //    $image->move($imageName);
    //    Info::create([
    //     'name'=> $request->name,
    //    'email'=> $request->email,
    //    'password'=> $request->password,
    //    //'password_confirm'=> $request->password_confirm,
    //    'phone'=> $request->phone,
    //    'adress'=> $request->adress,
    //    'date_of_birth'=> $request->date_of_birth,

    //    'image'=>  $request->file('image'),

    //   ]);

    //    return response()->json(['success' => ' yes yes i can do it'],200);

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
//public/try@il.com_1730311026_front-view-man-eating-apple_23-2149857625.avif
//public/try@il.com_front-view-man-eating-apple_23-2149857625.avif
//public/try@il.com

