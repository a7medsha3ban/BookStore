<?php

namespace App\Http\Controllers;

use App\Book;
use App\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiBookController extends Controller
{
    public function listBooks(){
        $books=Book::get();
        return response()->json($books);
    }


    public function showBook($id){
//      2 ways to find something with the id
//      $book=Book::find($id);
        $book=Book::where('id','=',$id)->first();
        return response()->json($book);
    }


    public function addBook(Request $request){
        //we can validate by 2 methods

        //first validation method to validate using function validate in Request class
//        $validated=$request->validate([
//            'bookName'=>'required|max:100|min:3',
//            'bookDescription'=>'required|max:100|min:3',
//            'bookImage'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
//        ]);

        //second validation method to validate Manually Creating Validators
        $validated=validator::make($request->all(),[
            'bookName'=>'required|max:100|min:3',
            'bookDescription'=>'required|max:100|min:3',
            'bookImage'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_ids' => 'required',
            'category_ids.*' => 'exists:categories,id',
        ]);

        if($validated->fails()){
            $errors=$validated->errors();
            return response()->json($errors);
        }

        //image upload
//        'bookImage' dh el esm el gy mn el request
        if ($request->hasFile('bookImage')){
            $image= $request->file('bookImage');
            $name = time().'_'.\Str::random(15).'.'.$image
                    ->getClientOriginalExtension();
            $destinationPath=public_path('/images');
            $image->move($destinationPath,$name);
            $imagePath='images/'.$name;
        }




        $book = new Book(); //3arft book geded
        //col           form input
        $book->name=$request->bookName;
        $book->description=$request->bookDescription;
        $book->image=$imagePath;
        $book->save();
        $book->categories()->sync($request->category_ids);
        $success_message= 'Book saved successfully';
        return response()->json($success_message);

    }


    public function updateBook($id,Request $request){
        $validated=validator::make($request->all(),[
            'bookName'=>'required|max:100|min:3',
            'bookDescription'=>'required|max:100|min:3',
            'bookImage'=> 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_ids' => 'required',
            'category_ids.*' => 'exists:categories,id',
        ]);

        if($validated->fails()){
            $errors=$validated->errors();
            return response()->json($errors);
        }
        //get the book
        $book=Book::find($id);
        $book->name=$request->bookName;
        $book->description=$request->bookDescription;

        if ($request->hasFile('bookImage')){
            $image= $request->file('bookImage');
            $name = time().'_'.\Str::random(15).'.'.$image
                    ->getClientOriginalExtension();
            $destinationPath=public_path('/images');
            $image->move($destinationPath,$name);
            $imagePath='images/'.$name;
            if(isset($book->image)){
                unlink($book->image);
            }
            $book->image=$imagePath;
        }
        $book->categories()->sync($request->category_ids);
        $book->save();
        $success_message= 'Book Updated Successfully';
        return response()->json($success_message);
    }


    public function deleteBook($id){
        $book=Book::find($id);
        if(isset($book->image)){
            unlink($book->image);
        }
        //momken bel detach aw sync([]) array fadya
//      $book->categories()->detach();
        $book->categories()->sync([]);
        $book->delete();
        $success_message= 'Book Deleted Successfully';
        return response()->json($success_message);
    }

}
