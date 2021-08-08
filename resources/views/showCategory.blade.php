@extends('Layouts.category-layout')
@section('content')

<div>
        <h1>{{$category->name}}</h1>
        <a href="{{URL('/categories/edit/'.$category->id)}}">Edit category</a>
        <a href="{{URL('/categories/delete/'.$category->id)}}">Delete category</a>
        <a href="{{URL('/categories/list')}}">return to all categories</a>
        <hr/>
</div>
@endsection
