@extends('layouts.app')
@section('styles')
<style>
    .reviewFeaturedImage{
        object-fit:cover;
        object-positon: center center;
        height: 600px;
    }
    
    .review-info{
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .wp-block-image{
        width: fit-content;
        margin: 30px auto 30px auto;
    }
    
    p{
        margin: 0;
    }
</style>
<link rel="stylesheet" href="{{ url('assets/css/rating.css') }}" type="text/css" />
@endsection
@section('content')
<section class="section">
	<div class="container">
		<article class="row mb-4">
			<div class="col-lg-10 mx-auto mb-4">
				<h1 class="h2 mb-3">{{ $review->title }}</h1>
				<ul class="list-inline post-meta mb-3 review-info">
				    <div>
    					<li class="list-inline-item"><i class="ti-user mr-2"> </i> <a href="{{ url($review->user->name) }}">{{ $review->user->name }}</a></li>
    					<li class="list-inline-item"><span class="ml-1">-</span>
    					<li class="list-inline-item">{{ \Carbon\Carbon::parse($review->created_at)->format('M d, Y') }}</li>
    					<li class="list-inline-item"><span class="ml-1">-</span>
    					<li class="list-inline-item"><a href="{{ url('?type=' . $review->type) }}" class="ml-1">{{ ucfirst($review->type) }}</a></li>
    					<li>
					</div>
					    <div class="star-source">
                          <svg>
                             <linearGradient x1="50%" y1="5.41294643%" x2="87.5527344%" y2="65.4921875%" id="grad">
                                <stop stop-color="#ce8460" offset="0%"></stop>
                                <stop stop-color="#ce8460" offset="60%"></stop>
                                <stop stop-color="#ce8460" offset="100%"></stop>
                            </linearGradient>
                            <symbol id="star" viewBox="153 89 106 108">   
                              <polygon id="star-shape" stroke="url(#grad)" stroke-width="5" fill="currentColor" points="206 162.5 176.610737 185.45085 189.356511 150.407797 158.447174 129.54915 195.713758 130.842203 206 95 216.286242 130.842203 253.552826 129.54915 222.643489 150.407797 235.389263 185.45085"></polygon>
                            </symbol>
                        </svg>
                        </div>
                        <div class="star-container">
                          <input type="radio" name="star" id="five">
                          <label for="five">
                            <svg class="star">
                              <use xlink:href="#star"/>
                            </svg>
                          </label>
                          <input type="radio" name="star" id="four">
                          <label for="four">
                            <svg class="star">
                              <use xlink:href="#star"/>
                            </svg>
                          </label>
                          <input type="radio" name="star" id="three">
                          <label for="three">
                            <svg class="star">
                              <use xlink:href="#star"/>
                            </svg>
                          </label>
                          <input type="radio" name="star" id="two">
                          <label for="two">
                            <svg class="star">
                              <use xlink:href="#star" />
                            </svg>
                          </label>
                          <input type="radio" name="star" id="one">
                          <label for="one">
                           <svg class="star">
                            <use xlink:href="#star" />
                           </svg>
                          </label>
                        </div>
					</li>
				</ul>
				
			</div>
			
			<div class="col-12 mb-3">
				<div class="post-slider">
					<img src="data:image/jpeg;base64,{{ $review->featuredImage }}" class="img-fluid reviewFeaturedImage" alt="post-thumb">
				</div>
			</div>
			<div class="col-lg-7 mx-auto">
				<div class="content">
				    {!! $review->render() !!}
				</div>
			</div>
		</article>
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