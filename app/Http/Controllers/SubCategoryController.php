<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    public function index(){
        $category = \DB::table('categories')->select('title', 'id')->WHERE('status',1)->get();
        return view('user.sub-category',['categorys'=>$category]);
    }

    public function store(Request $req){
        $req->validate([
            'category'=> 'required',
            'sub_category'=> 'required',
            'sub_description'=> 'required'
        ],[
            'category.required'=>'This Feild is required!',
            'sub_category.required'=>'This Feild is required!',
            'sub_description.required'=>'This Feild is required!'
        ]);

        $Subcategory = new SubCategory;
        $Subcategory->categories_id  = $req->category;
        $Subcategory->title = $req->sub_category;
        $Subcategory->description = $req->sub_description;
        $Subcategory->save();

        return redirect()->back()->withSuccess('Subcategory Created');
    }

    public function view(){
        // $category = SubCategory::all();
        $category = \DB::table('sub_categories')
            ->join('categories', 'categories.id', '=', 'sub_categories.categories_id')
            ->select('sub_categories.*', 'categories.title As parentCat')
            ->WHERE('sub_categories.status', '=',1)
            ->paginate(10);
        return view('user.view-subCategory',['categorys'=>$category]);
    }

    public function destroy($id){
        $Category = SubCategory::find($id);
        if(!is_null($Category)){
            $Category->delete();
        }
        return redirect()->back()->withSuccess('Subcategory Deleted');
    }

    public function singleRecord($id){
        $category = \DB::table('categories')->select('title', 'id')->get();

        $SubCategory = SubCategory::WHERE('id',$id)->first();
        if(!is_null($SubCategory)){
            return view('user.update-subcategory',['SubCategorys'=>$SubCategory],['categorys'=>$category]);
        }
        return redirect('/view-subCategory');
    }

    public function update(Request $req){
        $req->validate([
            'category'=> 'required',
            'sub_category'=> 'required',
            'status'=> 'required',
            'sub_description'=> 'required'
        ],[
            'category.required'=>'This Feild is required!',
            'sub_category.required'=>'This Feild is required!',
            'status.required'=>'This Feild is required!',
            'sub_description.required'=>'This Feild is required!'
        ]);

        $SubCategory = SubCategory::WHERE('id',$req->cid)->first();
        if(!is_null($SubCategory)){
            $SubCategory->categories_id  = $req->category;
            $SubCategory->title = $req->sub_category;
            $SubCategory->description = $req->sub_description;
            $SubCategory->status = $req->status;
            $SubCategory->save();
            return redirect()->back()->withSuccess('Subcategory Updated');
        }
        return redirect('/view-subCategory');
    }

    public function search(Request $req){
        $searchStr = $req->input('search');
        $category = \DB::table('sub_categories')
        ->join('categories', 'categories.id', '=', 'sub_categories.categories_id')
        ->select('sub_categories.*', 'categories.title As parentCat')
        ->where(function($q) use($searchStr){
            $q->Where('categories.title', 'Like', "%".$searchStr."%")
            ->orWhere('sub_categories.title', 'Like', "%".$searchStr."%");
        })
        ->Where('sub_categories.status', '=',1)
        ->get();
        return response()->json([
            'status'=>1,
            'category'=>$category
        ]);
    }
}
