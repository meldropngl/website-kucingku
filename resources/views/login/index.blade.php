@extends('layouts.main')

@section('container')     

<div class="row justify-content-center">
	<div class="col-lg-4">

    @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
  {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

 @if(session()->has('loginError'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
  {{ session('loginError') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<main class="form-signin w-100 m-auto text-center">
  <form action="/login" method="post">
    @csrf
    <img class="mb-4" src="/icon/icon.png" alt="" width="50" height="50">
    <h1 class="h3 mb-3 fw-normal">Please Login</h1>

    <div class="form-floating">
      <input type="text" name="username" class="form-control" id="username" placeholder="algio">
      <label for="username">Username</label>
    </div>
    <div class="form-floating">
      <input type="password" name="password" class="form-control" id="password" placeholder="Password">
      <label for="password">Password</label>
    </div>

    <div class="form-check text-start my-3">
      <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
      <label class="form-check-label" for="flexCheckDefault">
        Remember me
      </label>
    </div>
    <button class="btn btn-primary w-100 py-2" type="submit">Login</button>
  </form>
	<small class="d-block my-3">Not registered? <a href="/register">Register Now!</a></small>
</main>
	</div>
</div>

@endsection