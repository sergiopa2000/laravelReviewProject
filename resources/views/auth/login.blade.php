@extends('layouts.app')
@section('styles')
<style>
  header{
    position: absolute !important;
  }

  section{
    height: 100%;
  }
</style>
@endsection

@section('content')
<section class="d-flex align-items-center">
	<div class="container login-container">
	  @if(session('status'))
          <div class="alert alert-success mb-4" style="width: 67%;margin: auto;">{{ session('status') }}</div>
    @endif
	  @if(session('loginVerificationError'))
          <div class="alert alert-danger mb-4" style="width: 67%;margin: auto;">{{ session('loginVerificationError') }}</div>
    @endif
    @if(session('successRegister'))
          <div class="alert alert-success mb-2" style="width: 67%;margin: auto;">Your account has been successfully registered!</div>
          <div class="alert alert-warning mb-4" style="width: 67%;margin: auto;">{{ session('successRegister') }}</div>
    @endif
    @if(session('emailChanged'))
          <div class="alert alert-success mb-2" style="width: 67%;margin: auto;">Your email has been successfully changed!</div>
          <div class="alert alert-warning mb-4" style="width: 67%;margin: auto;">{{ session('emailChanged') }}</div>
    @endif
		<div class="row">
			<div class="col-md-4">
				<div class="content mb-5">
					<h1 id="ask-us-anything-br-or-just-say-hi">Dont have an <br>Account?</h1>
					<p>If you dont have an account yet you can register here!<br>
					By registering with us, you will be able to access all of our great services. </p>
					<a href="register" class="btn btn-outline-primary">Register now</a>
					</p>
				</div>
			</div>
			<div class="col-md-4">
				<form method="POST" action="{{ route('login') }}">
          @csrf
					<div class="form-group">
						<label for="email">Your Email (Required)</label>
						<input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
					</div>
					<div class="form-group">
						<label for="password">Your password (Required)</label>
						<input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
					</div>
           @error('password')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
          <div class="form-check mb-3 mt-3">
              <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
              <label class="form-check-label" for="remember">
                  {{ __('Remember Me') }}
              </label>
          </div>
          <div class="row">
            <div class="col-6">
              <input type="submit" class="btn btn-primary px-4" value="Login"></input>
            </div>
            <div class="col-6 text-right forgot-password">
              @if (Route::has('password.request'))
                    <a class="btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Password?') }}
                    </a>
                @endif
            </div>
          </div>
				</form>
			</div>
		</div>
	</div>
</section>
@endsection
