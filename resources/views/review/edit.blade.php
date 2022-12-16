@extends('layouts.app')
@section('styles')
<link rel="stylesheet" href="{{asset('vendor/laraberg/css/laraberg.css')}}">
<link href="{{ url('assets/css/uploader.css') }}" rel="stylesheet" type="text/css">
<style>
   body, html{
      height: unset;
   }
   
   .images-container{
       position: relative;
       display: flex;
       flex-wrap: wrap;
       gap: 15px;
   }
   
   .images-container > * {
       flex-shrink: 0;
   }
   .images-container img{
       position: relative;
       border-radius: 12px;
       height: 120px;
       width: 120px;
       object-fit:cover;
   }
   
   .images-container div{
       margin-top: 10px;
       position: relative;
   }
   
   .images-container div span {
   color: white !important;
    border: 0;
    font-family: serif;
    z-index: 3;
    align-content: center;
    font-size: 10px;
    font-weight: bold;
    text-align: center;
    line-height: 22px;
    color: white;
    position: absolute;
    top: -5px;
    left: -5px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #e50000;
    cursor: pointer;
}
</style>
@endsection
@section('content')
    <div class="container form-container mb-5 mt-4">
       @error('reviewUpdateError')
          <div class="alert alert-danger">{{ $message }}</div>
       @enderror
      @error('imageDeleteError')
          <div class="alert alert-danger">{{ $message }}</div>
       @enderror
        <form id="createReviewForm" action="{{ url('review/' . $review->id . '?admin=' . $admin) }}" method="post" enctype="multipart/form-data" style="width: 100%;">
           @csrf
           @method('put')
			<div class="form-group mb-3">
    			<label for="type">Type</label>
             <select name="type" class="form-select @error('type') is-invalid @enderror">
                 
                @foreach($types as $type)
                    <option value="{{ $type->name }}" @if($type->name == $review->type) selected @endif>{{ ucfirst($type->name) }}</option>
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
                 <input type="file" name="featuredImage" accept="image/png, image/jpeg, image/jpg" class="form-control @error('featuredImage') is-invalid @enderror" value="{{ old('featuredImage') }}">
                @error('featuredImage')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
			</div>
	       <div class="form-group mb-3">
			    <label for="carouselImage">Carousel Images - Max 2MB each</label>
                <div class="images-container">
                    @foreach($review->images as $image)
                    <div>
                       <img loading="lazy" src="{{ url('review/display/'. $image->path) }}" class="slider-img" alt="post-thumb">
                       <span class="deleteImageButton" data-url="{{ url('deleteImage/' . $image->id) }}">&#10006;</span>
                    </div>
                    @endforeach
                </div>
                <div class="multiple-uploader" id="multiple-uploader">
                    <div class="mup-msg">
                        <span class="mup-main-msg">Click to add new images.</span>
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
             <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $review->title) }}" minlength="8" maxlength="60" required>
              @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
             @enderror
			</div>
		   <div class="form-group mb-3">
			    <label for="excerpt">Review Excerpt</label>
             <textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror"minlength="10" maxlength="300" required>{{ old('excerpt', $review->excerpt) }}</textarea>
              @error('excerpt')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
             @enderror
			</div>
			<div class="form-group">
			    <label for="content">Review Content</label>
			    <textarea name="content" id="createNewReview" required>{{ $review->content }}</textarea>
			</div>
            <input class="btn btn-primary mt-3 btn-lg" type="submit" value="Edit Review"/>
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
   <!-- Delete Image form -->
  <form action="" method="post" id="deleteImageForm">
       @csrf
       @method('delete')
   </form>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ url('assets/js/delete-image.js') }}" defer></script>
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