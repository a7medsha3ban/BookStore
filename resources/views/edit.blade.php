@extends('Layouts.book-layout')

@section('content')
    @if($errors)
        @foreach($errors->all() as $error)
            <div class="alert alert-danger">{{$error}}</div>
        @endforeach
    @endif

    <form action="{{URL('/books/update/'.$book->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Book Name</label>
            <input type="text" value="{{$book->name}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="bookName">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Description</label>
            <input type="text" value="{{$book->description}}" class="form-control" id="exampleInputPassword1" name="bookDescription">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Image</label>
            <input type="file" class="form-control" id="exampleInputPassword1" name="bookImage">
        </div>

        <button type="submit" class="btn btn-primary">Edit</button>
    </form>

@endsection
