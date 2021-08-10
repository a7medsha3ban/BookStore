@extends('Layouts.layout')

@section('content')
    @if($errors)
        @foreach($errors->all() as $error)
            <div class="alert alert-danger">{{$error}}</div>
        @endforeach
    @endif

    <form action="{{URL('/categories/update/'.$category->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Category Name</label>
            <input type="text" value="{{$category->name}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="categoryName">
        </div>

        <button type="submit" class="btn btn-primary">Edit</button>
    </form>

@endsection
