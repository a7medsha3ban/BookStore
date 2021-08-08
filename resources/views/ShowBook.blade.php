@extends('Layouts.book-layout')
@section('content')

<div>
        <h1>{{$book->name}}</h1>
        <p>{{$book->description}}</p>
        @if($book->image)
        <img class="img-fluid" src="{{asset($book->image)}}" width="500">
        @endif
        <a href="{{URL('/books/edit/'.$book->id)}}">Edit Book</a>
        <a href="{{URL('/books/delete/'.$book->id)}}">Delete Book</a>
        <a href="{{URL('/books/list')}}">return to all books</a>
        <hr/>
</div>
@endsection
