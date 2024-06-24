<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Subjects;

class SubjectController extends Controller
{
    public function index(){
        $batch = \DB::table('batches')->select('name', 'id')->WHERE('status',1)->get();
        $category = \DB::table('categories')->select('title', 'id')->WHERE('status',1)->get();
        return view('user.create-subject',['categorys'=>$category],['batchs'=>$batch]);
    }

    public function fetchSubcategory($category = null){
        $subcategory = \DB::table('sub_categories')->select('title', 'id')->WHERE('categories_id',$category)->get();
        return response()->json([
            'status'=>1,
            'subcategorys'=>$subcategory
        ]);
    }

    public function insert(Request $req){
        $req->validate([
            'name'=> 'required',
            'description'=> 'required',
            'image'=>'required | mimes:jepg,jpg,png,gif | max:1000',
            'category'=>'required',
            'subcategory'=>'required'
        ],[
            'name.required'=>'This Feild is required!',
            'description.required'=>'This Feild is required!',
            'image.required'=>'This Feild is required!',
            'image.mimes'=>'Invalid File Type',
            'image.max'=>'File is too large',
            'category.required'=>'This Feild is required!',
            'subcategory.required'=>'This Feild is required!'
        ]);

        $imageName =  "COURSE-".rand().".".$req->image->extension();
        $req->image->move(public_path('upload/courses/') , $imageName);

        $subject = new Subjects;
        $subject->categories_id = $req->category;
        $subject->sub_categories_id  = $req->subcategory;
        $subject->batches_id  = $req->batch;
        $subject->sub_name  = $req->name;
        $subject->sub_description  = $req->description;
        $subject->sub_image  =  $imageName;
        $subject->save();

        return redirect()->back()->withSuccess('Subject Created');
    }
    
    public function singleRecord($id){
        $subject = Subjects::WHERE('id',$id)->first();
        $batch = \DB::table('batches')->select('name', 'id')->WHERE('status',1)->get();
        $category = \DB::table('categories')->select('title', 'id')->WHERE('status',1)->get();
        if(!is_null($subject)){
            return view('user.update-subject',['subjects'=>$subject,'batchs'=>$batch,'categorys'=>$category]);
        }
        return redirect('/all-subjects');
    }

    public function update(Request $req){

        $req->validate([
            'name'=> 'required',
            'description'=> 'required',
            'image'=>'mimes:jepg,jpg,png,gif | max:1000',
            'category'=>'required',
            'subcategory'=>'required',
            'batch'=>'required'
        ],[
            'name.required'=>'This Feild is required!',
            'description.required'=>'This Feild is required!',
            'image.mimes'=>'Invalid File Type',
            'image.max'=>'File is too large',
            'category.required'=>'This Feild is required!',
            'subcategory.required'=>'This Feild is required!',
            'batch.required'=>'This Feild is required!'
        ]);

        $subject = Subjects::WHERE('id',$req->sid)->first();

        if(isset($req->image)){
            $imageName =  "COURSE-".rand().".".$req->image->extension();
            $req->image->move(public_path('upload/courses/') , $imageName);
            $subject->sub_image  =  $imageName;
        }

        $subject->categories_id = $req->category;
        $subject->sub_categories_id  = $req->subcategory;
        $subject->batches_id  = $req->batch;
        $subject->sub_name  = $req->name;
        $subject->sub_description  = $req->description;
        $subject->status = $req->status;
        $subject->save();

        return back()->withSuccess('Subject Updated');
    }

    public function search(Request $req){
        $searchStr = $req->input('search');
        $subject = \DB::table('subjects')       
        ->join('categories', 'categories.id', '=', 'subjects.categories_id',)
        ->join('sub_categories', 'sub_categories.id', '=', 'subjects.sub_categories_id')
        ->join('batches', 'batches.id', '=', 'subjects.batches_id')
        ->select('subjects.*', 'categories.title As parentCat','sub_categories.title As childCat','batches.name As batch')
        ->where(function($q) use($searchStr){
            $q->where('subjects.sub_name', 'Like', "%".$searchStr."%")
            ->orWhere('categories.title', 'Like',"%".$searchStr."%")
            ->orWhere('sub_categories.title', 'Like',"%".$searchStr."%");
        })
        ->where('subjects.status', '=', $req->input('status'))
        ->where('subjects.batches_id', '=', $req->input('batch'))
        ->get();
    
        return response()->json([
            'status'=>1,
            'subjects'=>$subject
        ]);
    }

    public function filter(Request $req){
        $subject = \DB::table('subjects')       
        ->join('categories', 'categories.id', '=', 'subjects.categories_id',)
        ->join('sub_categories', 'sub_categories.id', '=', 'subjects.sub_categories_id')
        ->join('batches', 'batches.id', '=', 'subjects.batches_id')
        ->select('subjects.*', 'categories.title As parentCat','sub_categories.title As childCat','batches.name As batch')
        ->where('subjects.status', '=', $req->input('filter_status'))
        ->where('subjects.batches_id', '=', $req->input('batch'))
        ->get();

        return response()->json([
            'status'=>1,
            'subjects'=>$subject
        ]);
    }

}
