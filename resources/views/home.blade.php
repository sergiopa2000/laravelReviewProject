@extends('layouts.app')
@section('styles')
<style>
	body, html{
		height: unset;
	}
	
	.slider-img{
		object-fit: cover !important;
		object-position: center center !important;
		height: 400px !important;
		width: 732px !important;
	}
</style>
@endsection
@section('content')
<section class="section" >
	<div class="container">
		@if(session('reviewCreated'))
			<div class="alert alert-success">{{ session('reviewCreated') }}</div>
		@endif
      @error('notOwnResource')
          <div class="alert alert-danger">{{ $message }}</div>
      @enderror
      @error('notAdmin')
          <div class="alert alert-danger">{{ $message }}</div>
      @enderror
		<div class="row" style="gap: 30px;">
			<div class="col-lg-7  mb-5 mb-lg-0">
				<a href="{{ url('review/create') }}"class="btn btn-primary mb-3 create-new-post">New Review</a>
				@if(count($reviews) == 0)
					No reviews yet...
				@endif
				@foreach($reviews as $review)
				<article class="row mb-5">
					<div class="col-12">
						<div class="post-slider">
							@foreach($review->images as $image)
								<img loading="lazy" src="{{ url('review/display/'. $image->path) }}" class="slider-img" alt="post-thumb">
							@endforeach
						</div>
					</div>
					<div class="col-12 mx-auto">
						<h3><a class="post-title" href="{{ url('review/' . $review->id) }}">{{ $review->title }}</a></h3>
						<ul class="list-inline post-meta mb-4">
							<li class="list-inline-item"><i class="ti-user mr-2">&nbsp;</i>
								<a href="{{ url($review->user->name) }}">{{ $review->user->name }}</a>
							</li>
							<li class="list-inline-item"><span class="ml-1">-</span>
							<li class="list-inline-item">{{ \Carbon\Carbon::parse($review->created_at)->format('M d, Y') }}</li>
							<li class="list-inline-item"><span class="ml-1">-</span>
							<li class="list-inline-item"><a href="{{ url('?type=' . $review->type) }}" class="ml-1">{{ ucfirst($review->type) }}</a>
							</li>
						</ul>
						<p>{{ $review->excerpt }}</p> <a href="{{ url('review/' . $review->id) }}" class="btn btn-outline-primary">Continue Reading</a>
					</div>
				</article>
				@endforeach
			</div>
			<aside class="col-lg-4">
   <!-- categories -->
   <div class="widget">
      <h5 class="widget-title"><span>Categories</span></h5>
      <ul class="list-unstyled widget-list">
         <li><a href="?type=book" class="d-flex align-items-center justify-content-between">Book
               <small class="ml-auto">({{ $categoryCount['book'] }})</small></a>
         </li>
         <li><a href="?type=movie" class="d-flex align-items-center justify-content-between">Movie
               <small class="ml-auto">({{ $categoryCount['movie'] }})</small></a>
         </li>
         <li><a href="?type=music disc" class="d-flex align-items-center justify-content-between">Music Disc
               <small class="ml-auto">({{ $categoryCount['music disc'] }})</small></a>
         </li>
      </ul>
   </div>
   <!-- latest post -->
   <div class="widget">
      <h5 class="widget-title"><span>Latest Reviews</span></h5>
      <!-- post-item -->
		@if(count($reviews) == 0)
			No reviews yet...
		@endif
      @foreach($latestReviews as $review)
      <ul class="list-unstyled widget-list">
         <li class="media widget-post align-items-center">
            <a href="{{ url('review/' . $review->id) }}">
               <img loading="lazy" class="mr-3" src="data:image/jpeg;base64,{{ $review->featuredImage }}">
            </a>
            <div class="media-body">
               <h5 class="h6 mb-0"><a href="{{ url('review/' . $review->id) }}">{{ $review->title }}</a></h5>
               <small>{{ \Carbon\Carbon::parse($review->created_at)->format('M d, Y') }}</small>
            </div>
         </li>
      </ul>
      @endforeach
   </div>
			</aside>
		</div>
	</div>
</section>

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

