<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Crud;



class CrudController extends Controller
{
    public function index()
    {	
    	return view('crud',["model"=>Crud::get()]);
    }
    public function create(Request $request)
    {
    	if ($request->isMethod('post')) {
    		$name = uniqid()."-".Input::file('img')->getClientOriginalName();
    		$path = Input::file('img')->move(public_path()."/storage/",$name);
    		if ($path) {
    			$post = $request->all();
    			$model = new Crud;
    			$model->title = $post["title"];
    			$model->categorie = $post["category"];
    			$model->image = $name;
    			if ($model->save()) {
    				$data = [
    					"message"=> "Item Has Been Created",
    					"flag" => 1,
    					"items"=>[
    						"title"=>$post["title"],
    						"category"=>$post["category"],
    						"image"=>url("storage")."/".$name,
    						"id"=>$model->id,
    					]
    				];
    				$data = json_encode($data);
    				return response($data,200);
    			}
    		}
    	}
    	return response("Something went wrong",400);
    }
    public function delete(Request $request)
    {
    	if ($request->isMethod('post')) {
    		$post = $request->all();
    		$id = $post['id'];
    		$item = Crud::find($id);
    		if ($item->delete()) {
    			$data = [
    				"message"=> "Item Has Been Deleted ... !",
    				"flag" => 1,
    				"items"=>[
   						"id"=>$id,
   					]
   				];
   				$data = json_encode($data);
   				return response($data,200);
    		}
    	}
    	return response("Something went wrong",400);
    }
    public function update(Request $request)
    {
    	if ($request->isMethod('post')) {
    		$post = $request->all();
    		$id = $post['id'];
    		$model = Crud::find($id);
    		if (Input::file('img')) {
    			$name = uniqid()."-".Input::file('img')->getClientOriginalName();
    			$path = Input::file('img')->move(public_path()."/storage/",$name);
    			$model->image = $name;
    		}
    		$model->title = $post["title"];
    		$model->categorie = $post["category"];
    		if ($model->save()) {
    			$data = [
    				"message"=> "Item Has Been Updated",
    				"flag" => 1,
    				"items"=>[
    					"title"=>$post["title"],
    					"category"=>$post["category"],
    					"image"=>url("storage")."/".$model->image,
    					"id"=>$model->id,
    				]
    			];
    			$data = json_encode($data);
    			return response($data,200);
    		}
    	}
    	return response("Something went wrong",400);
    }
}
