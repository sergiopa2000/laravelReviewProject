@extends('layouts.app')
@section('styles')
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ url('assets/css/special.css') }}">
@endsection
@section('content')
<div class="register-container d-flex align-items-center" style="height:calc(100% - 70px);">
  <div class="register-img"></div>
  <form method="POST" action="{{ route('register') }}">
      @csrf
      <div class="row justify-content-center register-form">
        <div class="col-md-9">
          <div class="card-group mb-0">
            <div class="card p-4">
              <div class="card-body">
                <h1>Register</h1>
                <p class="text-muted">Create your account</p>
                 <div class="input-group mb-3">
                  <span class="input-group-text"><i class="fa fa-user"></i></span>
                  <input required type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{ old('name') }}">
                  @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
                <div class="input-group mb-3">
                  <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                  <input required type="text" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}">
                  @error('email')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
                <div class="input-group mb-3">
                  <span class="input-group-text"><i class="fa fa-lock"></i></span>
                  <input required type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                   @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
                  <div class="input-group mb-3">
                  <span class="input-group-text"><i class="fa fa-lock"></i></span>
                  <input required type="password" name="password_confirmation" class="form-control" placeholder="Password confirm">
                </div>
                <div class="row">
                  <div class="col-6">
                    <input type="submit" class="btn btn-primary px-4" value="Register"></input>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<!--aaaaa-->
</div>
@endsection
