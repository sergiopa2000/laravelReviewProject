@extends('layouts.app')
@section('styles')
<link rel="stylesheet" href="{{asset('vendor/laraberg/css/laraberg.css')}}">
<link href="{{ url('assets/css/uploader.css') }}" rel="stylesheet" type="text/css">
<style>
    main{
        height: 91vh;
    }
    
    #start{
        width: 40%;
        display: flex;
        align-items: center;
    }
    
</style>
@endsection
@section('content')
    <div class="container form-container mb-5 mt-4">
       @error('reviewUpdateError')
          <div class="alert alert-danger">{{ $message }}</div>
       @enderror
        <form action="{{ url($user->name . '/update?admin=true') }}" method="post" style="width: 100%;">
           @csrf
           @method('put')
		    <div class="form-group mb-3">
			    <label for="name">User name</label>
             <input type="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" minlength="8" maxlength="60" required>
              @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
             @enderror
			</div>
		    <div class="form-group mb-3">
		    <label for="email">User email</label>
             <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" minlength="8" maxlength="60" required>
              @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
             @enderror
			</div>
		    <div class="form-group mb-3">
			 <label for="verified">User verified</label>
			 <select name="verified" class="form-select @error('verified') is-invalid @enderror">
			     @if($user->email_verified_at)
			         <option value="yes" selected>Yes</option>
			         <option value="no">No</option>
			     @else
     		         <option value="yes">Yes</option>
			         <option value="no" selected>No</option>
			     @endif
			 </select>
              @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
             @enderror
			</div>
		    <div class="form-group mb-3">
			    <label for="password">User new password</label>
             <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
              @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
             @enderror
			</div>
            <input class="btn btn-primary mt-3 btn-lg" type="submit" value="Edit User"/>
        </form>
    </div>
   <!-- Delete Image form -->
  <form action="" method="post" id="deleteImageForm">
       @csrf
       @method('delete')
   </form>
@endsection