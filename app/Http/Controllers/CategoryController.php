<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //function to list all books in database
    function list(){
        $categories=category::get();
//        dd($categories);
//        'categories' -> dh el esm el htroh beh fe el blade w $books dh el variable el fe el controller
        return view('categories.categories',[
            // 'categories' -> dh el esm el htroh beh fe el blade w $books dh el variable el fe el controller
            'categories'=>$categories,
        ]);
    }

    //function to show a book from database with specific id
    function show($id){
//      2 ways to find something with the id
//      $book=Book::find($id);
        $category=category::where('id','=',$id)->first();
        return view('categories.showCategory',[
            'category'=>$category,
        ]);
    }

    //function to create form
    function create(){
        return view('categories.createCategory');
    }

    //function to create new book in database
    function add(Request $request){
        //we can validate by 2 methods

        //first validation method to validate using function validate in Request class
//        $validated=$request->validate([
//            'bookName'=>'required|max:100|min:3',
//            'bookDescription'=>'required|max:100|min:3',
//            'bookImage'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
//        ]);

        //second validation method to validate Manually Creating Validators
        $validated=validator::make($request->all(),[
            'categoryName'=>'required|max:100|min:3',
        ]);

        if($validated->fails()){
            return redirect('categories/create')
                ->withErrors($validated)
                ->withInput();
        }


        $category = new category(); //3arft book geded
        //col           form input
        $category->name=$request->categoryName;
        $category->save();
        return redirect('categories/list');

    }

    //function to edit a book in database
    function edit($id){
//      $book=Book::where('id','=',$id)->first();
        $category=category::find($id);
        return view('categories.editCategory',[
            'category'=>$category
        ]);
    }

    function update($id,Request $request){
        $validated=validator::make($request->all(),[
            'categoryName'=>'required|max:100|min:3',
        ]);

        if($validated->fails()){
            return redirect('categories/edit/{id}')
                ->withErrors($validated)
                ->withInput();
        }
        //get the book
        $category=category::find($id);
        $category->name=$request->categoryName;
        $category->save();
        return redirect('categories/show/'.$id);
    }

    //function to delete a book in database
    function delete($id){
        $category=category::find($id);
        $category->delete();
        return redirect('categories/list');
    }
}
