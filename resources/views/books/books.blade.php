@extends('Layouts.layout')

@section('content')

    @auth
        <h1>Notes:</h1>
        @foreach(Auth::user()->notes as $note)
        <p>-{{$note->content}}</p>
        @endforeach
        <a href="{{url('notes/create')}}" class="btn btn-info">Add New Note</a>
    @endauth

    @foreach($books as $book)
        <h1><a href="{{URL('/books/show',$book->id)}}">{{$book->name}}</a></h1>
        @foreach($book->categories as $category)
            <h5>{{$category->name}}</h5>
        @endforeach
        <p>{{$book->description}}
        @auth
            <p>
                <a href="{{URL('/books/edit/'.$book->id)}}">Edit Book</a>
                <a href="{{URL('/books/delete/'.$book->id)}}">Delete Book</a>
            </p>
        @endauth
        <hr/>
    @endforeach

@endsection
