<?php

namespace App\Http\Controllers;
use App\Book;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    //function to list all books in database
    function list(){
        $books=Book::get();
//        dd($books);
//        'books' -> dh el esm el htroh beh fe el blade w $books dh el variable el fe el controller
        return view('books.books',[
            // 'books' -> dh el esm el htroh beh fe el blade w $books dh el variable el fe el controller
            'books'=>$books,
        ]);
    }

    //function to show a book from database with specific id
    function show($id){
//      2 ways to find something with the id
//      $book=Book::find($id);
        $book=Book::where('id','=',$id)->first();
        return view('books.ShowBook',[
            'book'=>$book,
        ]);
    }

    //function to create form
    function create(){
        $categories = Category:: select('id','name')->get();
        return view('books.create',[
            'categories'=>$categories,
             compact($categories)
        ]);
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
            'bookName'=>'required|max:100|min:3',
            'bookDescription'=>'required|max:100|min:3',
            'bookImage'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_ids' => 'required',
            'category_ids.*' => 'exists:categories,id',
        ]);

        if($validated->fails()){
            return redirect('books/create')
                ->withErrors($validated)
                ->withInput();
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
        return redirect('books/list');

    }

    //function to edit a book in database
    function edit($id){
//      $book=Book::where('id','=',$id)->first();
        $book=Book::find($id);
        $categories = Category:: select('id','name')->get();
        return view('books.edit',[
            'book'=>$book,
            'categories'=>$categories,
            compact($categories)
        ]);
    }

    function update($id,Request $request){
        $validated=validator::make($request->all(),[
            'bookName'=>'required|max:100|min:3',
            'bookDescription'=>'required|max:100|min:3',
            'bookImage'=> 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_ids' => 'required',
            'category_ids.*' => 'exists:categories,id',
       ]);

        if($validated->fails()){
            return redirect('books/edit/{id}')
                ->withErrors($validated)
                ->withInput();
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
        return redirect('books/show/'.$id);
    }

    //function to delete a book in database
    function delete($id){
        $book=Book::find($id);
        if(isset($book->image)){
            unlink($book->image);
        }
        $book->delete();
        return redirect('books/list');
    }
}
