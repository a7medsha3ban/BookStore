@extends('Layouts.layout')

@section('content')
    @if($errors)
        @foreach($errors->all() as $error)
            <div class="alert alert-danger">{{$error}}</div>
        @endforeach
    @endif

    <form action="{{URL('handle-login')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email</label>
            <input type="email" value="{{old('email')}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" value="{{old('pass')}}" class="form-control" id="exampleInputPassword1" name="pass">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <a href="{{url('login/github')}}" class="btn btn-success">Sign in with github</a>
@endsection
