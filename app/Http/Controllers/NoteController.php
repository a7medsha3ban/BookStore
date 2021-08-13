<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    function create(){
        return view('notes.create');
    }
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
            'noteContent'=>'required|max:100',
        ]);

        if($validated->fails()){
            return redirect('notes/create')
                ->withErrors($validated)
                ->withInput();
        }


        $note = new note(); //3arft book geded
        //col           form input
        $note->content=$request->noteContent;
        $note->user_id=Auth::user()->id;
        $note->save();
        return redirect('books/list');

    }

}
