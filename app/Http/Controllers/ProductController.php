<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
	public function index(){
		
		return view('welcome');
	}
    public function allData(){
        $products = Product::orderBy('id','DESC')->get();
        return response()->json($products);
    }
    public function store(Request $request){
       
            $this->validate($request,[
            'name'=> 'required|unique:products',
            'des' => 'required'
           ]);
       
            $product = new Product();
            $product->name = $request->name;
            $product->des = $request->des;
            $product->save();
            return response()->json($product);
    
    }
    public function edit($id){
    	$product = Product::find($id);
    	if($product){
    		return response()->json($product);
    	}
    	else{
    		return response()->json('Data not found');
    	}
    }
    public function update(Request $request){
    	
    	$this->validate($request,[
    		'name'=> 'required|unique:products,id',
    		'des' => 'required'
    	]);

    	$product = Product::where('id',$request->id)->first();
    	$product->name = $request->name;
    	$product->des = $request->des;
    	$product->save();
    	return response()->json($product);

    }

	public function destroy($id){
		$category = Product::where('id',$id)->delete();
		$data = "Data Deleted Successfully";
		return response()->json($data);
	}
}
