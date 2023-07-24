@extends('layouts.main')

@section('container') 

<div class="row justify-content-center">
	<div class="col-lg-4">
<main class="form-signin w-100 m-auto text-center">
 <form action="/register" method="post">
    @csrf
    <img class="mb-4" src="/icon/icon.png" alt="" width="50" height="50">
    <h1 class="h3 mb-3 fw-normal">Please Registration</h1>
    <div class="form-floating">
      <input type="text" name="username" class="form-control @error('username')is-invalid @enderror" id="floatingInput" placeholder="algio" value="{{ old('username') }}">
      <label for="floatingInput">Username</label>
      @error('username')
      <div class="invalid-feedback text-start">
     {{ $message }}
    </div>
    @enderror
    </div>
    <div class="form-floating">
      <input type="password" name="password" class="form-control  @error('password')is-invalid @enderror" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
       @error('password')
      <div class="invalid-feedback text-start">
            {{ $message }}
      </div>
      @enderror
    </div>
    <div class="form-floating">
      <input type="password" name="confirm_password" class="form-control @error('confirm_password')is-invalid @enderror" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Confirm Password</label>
      @error('confirm_password')
      <div class="invalid-feedback text-start">
            {{ $message }}
      </div>
      @enderror
    </div>
    <button class="btn btn-primary w-100 py-2 mt-2" type="submit">Registration</button>
  </form>
	<small class="d-block my-3">You have account? <a href="/login">Login Now!</a></small>
</main>
	</div>
</div>

@endsection