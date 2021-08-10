@extends('Layouts.layout')

@section('content')

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
