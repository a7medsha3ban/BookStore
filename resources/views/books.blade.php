@extends('Layouts.book-layout')

@section('content')

    @foreach($books as $book)
        <h1><a href="{{URL('/books/show',$book->id)}}">{{$book->name}}</a></h1>
        <p>{{$book->description}}</p>
        <a href="{{URL('/books/edit/'.$book->id)}}">Edit Book</a>
        <a href="{{URL('/books/delete/'.$book->id)}}">Delete Book</a>
        <hr/>
    @endforeach

@endsection
