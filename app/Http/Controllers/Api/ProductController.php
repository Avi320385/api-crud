<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
       $products = Product::get();
       if($products->count()>0)
       {
          return ProductResource::collection($products);
       }
       else
       {
           return response()->json(['message'=>'Nothing to show'],200);
       }
    }
    public function store(Request $request)
    {

        $validator=Validator::make($request->all(),[
                            'name'=> 'required|string|max:255',
                            'price'=> 'required|integer',
                            'description'=> 'required',
                        ]);
         if($validator->fails())
         {
            return response()->json([
              'message'=>'all field are mandatory',
              'error'=>$validator->messages(),
            ],422);
         }
      $product= Product::create([
         'name'=> $request->name,
        'price'=> $request->price,
        'description'=> $request->description,
       ]);
       return response()->json([
           'message'=>'Product created Successfully',
           'data'=> new ProductResource($product)
       ],200);
    }
    public function show(Product $product)
    {
       return new ProductResource($product);
    }
    public function update(Request $request,Product $product)
    {
        $validator=Validator::make($request->all(),[
            'name'=> 'required|string|max:255',
            'price'=> 'required|integer',
            'description'=> 'required',
        ]);
        if($validator->fails())
        {
            return response()->json([
            'message'=>'all field are mandatory',
            'error'=>$validator->messages(),
        ],422);
    }
    $product -> update([
                            'name'=> $request->name,
                            'price'=> $request->price,
                            'description'=> $request->description,
                        ]);
        return response()->json([
                            'message'=>'Product UPDATED Successfully',
                            'data'=> new ProductResource($product)
                ],200);
           }
    public function destroy(Product $product)
    {
       $product->delete();

    return response()->json([
                        'message'=>'Product delete Successfully',

            ],200);
    }
}
