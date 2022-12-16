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
        <form action="{{ url('admin/type') }}" method="POST" style="width: 100%;">
           @csrf
           @method('post')
		    <div class="form-group mb-3">
			    <label for="name">Type name</label>
             <input type="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
              @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
             @enderror
            <input class="btn btn-primary mt-3 btn-lg" type="submit" value="Add Type"/>
        </form>
    </div>
@endsection