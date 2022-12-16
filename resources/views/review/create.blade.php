@extends('layouts.app')
@section('styles')
<link rel="stylesheet" href="{{asset('vendor/laraberg/css/laraberg.css')}}">
<link href="{{ url('assets/css/uploader.css') }}" rel="stylesheet" type="text/css">
<style>
   body, html{
      height: unset;
   }
</style>
@endsection
@section('content')
    <div class="container form-container mb-5 mt-4">
       @error('reviewCreateError')
          <div class="alert alert-danger">{{ $message }}</div>
       @enderror
        <form id="createReviewForm" action="{{ url('review') }}" method="post" enctype="multipart/form-data" style="width: 100%;">
           @csrf
			<div class="form-group mb-3">
    			<label for="type">Type</label>
             <select name="type" class="form-select @error('type') is-invalid @enderror">
                @foreach($types as $type)
                    <option value="{{ $type->name }}">{{ ucfirst($type->name) }}</option>
                @endforeach
             </select>
              @error('type')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
             @enderror
			</div>
		    <div class="form-group mb-3">
			    <label for="featuredImage">Featured Image - Max 2MB</label>
                 <input type="file" name="featuredImage" accept="image/png, image/jpeg, image/jpg" class="form-control @error('featuredImage') is-invalid @enderror" value="{{ old('featuredImage') }}"required>
                @error('featuredImage')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
			</div>
	       <div class="form-group mb-3">
			    <label for="carouselImage">Carousel Images - Max 2MB each</label>
                <div class="multiple-uploader" id="multiple-uploader">
                    <div class="mup-msg">
                        <span class="mup-main-msg">Click to upload images.</span>
                        <span class="mup-msg" id="max-upload-number">Upload up to 10 images</span>
                        <span class="mup-msg">Only png, jpg or jpeg images</span>
                    </div>
                </div>
                @error('carouselImages')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
			</div>
		    <div class="form-group mb-3">
			    <label for="title">Review Title</label>
             <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" minlength="8" maxlength="60" required>
              @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
             @enderror
			</div>
		   <div class="form-group mb-3">
			    <label for="excerpt">Review Excerpt</label>
             <textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror" minlength="10" maxlength="300" required>{{ old('excerpt') }}</textarea>
              @error('excerpt')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
             @enderror
			</div>
			<div class="form-group">
			    <label for="content">Review Content</label>
			    <textarea name="content" id="createNewReview" required>{{ old('content') }}</textarea>
			</div>
            <input class="btn btn-primary mt-3 btn-lg" type="submit" value="Create Review"/>
        </form>
    </div>
 <footer class="section-sm pb-0 border-top border-default">
      <div class="container">
         <div class="row justify-content-between">
            <div class="col-md-3 mb-4">
                 <a class="navbar-brand" href="{{ url('/') }}" style="font-size: 2em;">
                    MyReviews
                 </a>
            </div>

            <div class="col-lg-2 col-md-3 col-6 mb-4">
               <h6 class="mb-4">Quick Links</h6>
               <ul class="list-unstyled footer-list">
                  <li><a href="about.html">About</a></li>
                  <li><a href="contact.html">Contact</a></li>
                  <li><a href="privacy-policy.html">Privacy Policy</a></li>
                  <li><a href="terms-conditions.html">Terms Conditions</a></li>
               </ul>
            </div>

            <div class="col-lg-2 col-md-3 col-6 mb-4">
               <h6 class="mb-4">Social Links</h6>
               <ul class="list-unstyled footer-list">
                  <li><a href="#">facebook</a></li>
                  <li><a href="#">twitter</a></li>
                  <li><a href="#">linkedin</a></li>
                  <li><a href="#">github</a></li>
               </ul>
            </div>

            <div class="col-md-3 mb-4">
               <h6 class="mb-4">Subscribe Newsletter</h6>
               <form class="subscription" action="javascript:void(0)" method="post">
                  <div class="position-relative">
                     <i class="ti-email email-icon"></i>
                     <input type="email" class="form-control" placeholder="Your Email Address">
                  </div>
                  <button class="btn btn-primary btn-block rounded" type="submit">Subscribe now</button>
               </form>
            </div>
         </div>
         <div class="scroll-top">
            <a href="#start"><i class="ti-angle-up"></i></a>
         </div>
         <div class="text-center">
            <p class="content">&copy; 2022 - Design &amp; Develop By <a href="">Sergio Parejo Arroyo</a></p>
         </div>
      </div>
   </footer>
@endsection

@section('scripts')
<script src="https://unpkg.com/react@17.0.2/umd/react.production.min.js"></script>
<script src="https://unpkg.com/react-dom@17.0.2/umd/react-dom.production.min.js"></script>

<script src="{{ asset('vendor/laraberg/js/laraberg.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/js/editor.js') }}"></script>
<script src="{{ url('assets/js/multiple-uploader.js') }}"></script>
<script>
    let multipleUploader = new MultipleUploader('#multiple-uploader').init({
        maxUpload : 10, // maximum number of uploaded images
        maxSize:2, // in size in mb
        filesInpName:'carouselImages', // input name sent to backend
        formSelector: '#createReviewForm', // form selector
    });
</script>
@endsection