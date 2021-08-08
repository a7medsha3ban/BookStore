@extends('Layouts.category-layout')

@section('content')

    @foreach($categories as $category)
        <h1><a href="{{URL('/categories/show',$category->id)}}">{{$category->name}}</a></h1>
        <a href="{{URL('/categories/edit/'.$category->id)}}">Edit category</a>
        <a href="{{URL('/categories/delete/'.$category->id)}}">Delete category</a>
        <hr/>
    @endforeach

@endsection
