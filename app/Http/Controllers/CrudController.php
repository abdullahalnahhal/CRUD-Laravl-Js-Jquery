<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Crud;

/**
* @package Controllers
* @category CrudController
* @author Abdullah Al-Nahhal
* @copyright abdullahalnahhal@gmail.com
*/

class CrudController extends Controller
{
	/**
	* These method returns the view of index
	*/
    public function index()
    {	
    	return view('crud',["model"=>Crud::get()]);
    }
    /**
    * These method creates new element
    * @param Request $request the http request from the client
    * @return JSON $data the response of the creation
    */
    public function create(Request $request)
    {
    	## if the request type is post
    	if ($request->isMethod('post')) {
    		## name of the file
    		$name = uniqid()."-".Input::file('img')->getClientOriginalName();
    		## move the file and upload then return the path
    		$path = Input::file('img')->move(public_path()."/storage/",$name);
    		## if there is a path
    		if ($path) {
    			## get all request params
    			$post = $request->all();
    			## initiate new crud model
    			$model = new Crud;
    			$model->title = $post["title"];
    			$model->categorie = $post["category"];
    			$model->image = $name;
    			## save the model
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
    				## return the data
    				return response($data,200);
    			}
    		}
    	}
    	## return error
    	return response("Something went wrong",400);
    }
    /**
    * These method delete element
    * @param Request $request the http request from the client
    * @return JSON $data the response of the deletion
    */
    public function delete(Request $request)
    {
    	## if request is post
    	if ($request->isMethod('post')) {
    		## get all request params
    		$post = $request->all();
    		$id = $post['id'];
    		## find the model item
    		$item = Crud::find($id);
    		## if the item is deleted
    		if ($item->delete()) {
    			$data = [
    				"message"=> "Item Has Been Deleted ... !",
    				"flag" => 1,
    				"items"=>[
   						"id"=>$id,
   					]
   				];
   				$data = json_encode($data);
   				## return success and data
   				return response($data,200);
    		}
    	}
    	## return error and error message
    	return response("Something went wrong",400);
    }
    /**
    * These method update element
    * @param Request $request the http request from the client
    * @return JSON $data the response of the update
    */
    public function update(Request $request)
    {
    	## if the request is post
    	if ($request->isMethod('post')) {
    		## get all request params
    		$post = $request->all();
    		$id = $post['id'];
    		## initiate the model
    		$model = Crud::find($id);
    		## if there is a file
    		if (Input::file('img')) {
    			$name = uniqid()."-".Input::file('img')->getClientOriginalName();
    			$path = Input::file('img')->move(public_path()."/storage/",$name);
    			## save the image 
    			$model->image = $name;
    		}
    		$model->title = $post["title"];
    		$model->categorie = $post["category"];
    		## if the model is saved
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
    			## return the success and data
    			return response($data,200);
    		}
    	}
    	## return the error and message
    	return response("Something went wrong",400);
    }
}
