@extends('Layouts.book-layout')
@section('content')

<div>
        <h1>{{$book->name}}</h1>
        @foreach($book->categories as $category)
            <h5>{{$category->name}}</h5>
        @endforeach
        <p>{{$book->description}}</p>
        @if($book->image)
        <img class="img-fluid" src="{{asset($book->image)}}" width="500">
        @endif
        <hr/>
        <a href="{{URL('/books/edit/'.$book->id)}}">Edit Book</a>
        <a href="{{URL('/books/delete/'.$book->id)}}">Delete Book</a>
        <a href="{{URL('/books/list')}}">return to all books</a>
</div>
@endsection
