@extends('Layouts.layout')

@section('content')
    @if($errors)
        @foreach($errors->all() as $error)
            <div class="alert alert-danger">{{$error}}</div>
        @endforeach
    @endif

    <form action="{{URL('/notes/add')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Note Content</label>
            <input type="text" value="{{old('noteContent')}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="noteContent">
        </div>
        <button type="submit" class="btn btn-primary">Add Note</button>
    </form>

@endsection
