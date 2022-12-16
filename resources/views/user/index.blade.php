@extends('layouts.app')
@section('styles')
<style>
	body, html{
		height: unset;
	}
	
	.title-bordered{
		padding-right: 20px;
    	justify-content: space-between;
	}
	
	.slider-img{
		object-fit: cover !important;
		object-position: center center !important;
		height: 300px !important;
	}
	
	.review-info{
		display: flex;
		justify-content: space-between;
	}
	
	.ti-trash, .ti-pencil{
		font-size: 1.5em;
	}
</style>
@endsection
@section('content')
<section class="section-sm border-bottom">
	<div class="container">
		<div class="row user-profile-container">
			<div class="col-12" style="height: 60px;">
				<div class="title-bordered mb-5 d-flex align-items-center">
					<h1 class="h4">{{ $user->name }}</h1>
					<ul class="list-inline social-icons ml-auto mr-3 d-none d-sm-block">
						<li class="list-inline-item"><a href="#"><i class="ti-facebook"></i></a>
						</li>
						<li class="list-inline-item"><a href="#"><i class="ti-twitter-alt"></i></a>
						</li>
						<li class="list-inline-item"><a href="#"><i class="ti-github"></i></a>
						</li>
					</ul>
				</div>
			</div>
			<form action="{{ url($user->name . '/update') }}" method="POST" class="updateUserForm" enctype="multipart/form-data">
				@method('put')
				@csrf
				<div class="col-lg-3 col-md-4 mb-4 mb-md-0 text-center text-md-left d-flex flex-column gap-4" style="position:relative;">
					@if($ownProfile)<input type="file" name="profileImage" id="profileImageInput" accept="image/png, image/jpeg, image/jpg" class="imageUpload" hidden/>@endif
					<img draggable="false" loading="lazy" id="profileImage" class="rounded-lg img-fluid @if($ownProfile) ownProfileImage @endif profileImage" src="{{ asset('storage/profileImages/' . $user->profileImage) }}">
					@if($ownProfile)<input type="submit" class="btn btn-primary" value="Update Info"></input>@endif
				</div>
				<div class="col-lg-8 col-md-8 content text-md-left">
					<hr>
					<div class="d-flex align-items-center user-profile-row">
						<p>@if($ownProfile) Your @endif Username</p>
						<div class="form-group">
							@if($ownProfile)
							<input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
				            @error('name')
				                <span class="invalid-feedback" role="alert">
				                    <strong>{{ $message }}</strong>
				                </span>
				            @enderror
				            @else
				            <span>{{ $user->name }}</span>
				            @endif
						</div>
					</div>
					<hr>
					<div class="d-flex align-items-center user-profile-row">
						<p>@if($ownProfile) Your @endif Email</p>
						<div class="form-group">
							@if($ownProfile)
							<input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
				            @error('email')
				                <span class="invalid-feedback" role="alert">
				                    <strong>{{ $message }}</strong>
				                </span>
				            @enderror
				            	            @else
				            <span>{{ $user->email }}</span>
				            @endif
						</div>
					</div>
					<hr>
					@if($ownProfile)
					<div class="d-flex align-items-center user-profile-row">
						<p>Old password</p>
						<div class="form-group">
							<input type="password" name="oldPassword" class="form-control @error('oldPassword') is-invalid @enderror">
				           @error('oldPassword')
				              <span class="invalid-feedback" role="alert">
				                  <strong>{{ $message }}</strong>
				              </span>
				          @enderror
						</div>
					</div>
					<hr>
					<div class="d-flex align-items-center user-profile-row">
						<p>New password</p>
						<div class="form-group">
							<input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
				           @error('password')
				              <span class="invalid-feedback" role="alert">
				                  <strong>{{ $message }}</strong>
				              </span>
				          @enderror
						</div>
					</div>
					<hr>
					<div class="d-flex align-items-center user-profile-row">
						<p>Confirm password</p>
						<div class="form-group">
							<input type="password" name="password_confirmation" class="form-control">
						</div>
					</div>
					<hr>
					@endif
				</form>
			</div>
		</div>
	</div>
</section>

<section class="section-sm">
	<div class="container">
		<div class="row">
			@if(session('reviewDeleteSuccess'))
				<div class="alert alert-success">{{ session('reviewDeleteSuccess') }}</div>
			@endif
			@error('reviewDeleteError')
				<div class="aler alert-danger">{{ $message }}</div>
			@enderror
			<div class="col-lg-12">
				<div class="title text-center">
					@if($ownProfile)
					<h2 class="mb-5">Your Reviews</h2>
					@else
					<h2 class="mb-5">Reviews by {{ $user->name }}</h2>
					@endif
					@if(count($user->reviews) == 0)
					<p>No reviews yet...</p>
					@endif
				</div>
			</div>
			@foreach($user->reviews as $review)
			<div class="col-lg-4 col-sm-6 mb-4">
				<article class="mb-5">
					<div class="post-slider slider-sm">
							@foreach($review->images as $image)
								<img loading="lazy" src="{{ url('review/display/'. $image->path) }}" class="slider-img" alt="post-thumb">
							@endforeach
					</div>
					<h3 class="h5"><a class="post-title" href="{{ url('review/' . $review->id) }}">{{ $review->title }}</a></h3>
					<ul class="list-inline post-meta mb-2 review-info">
						<div>
							<li class="list-inline-item"><i class="ti-user mr-2"> </i><a href="author.html">{{ $review->user->name }}</a></li>
							<li class="list-inline-item"><span class="ml-1">-</span>
							<li class="list-inline-item">{{ \Carbon\Carbon::parse($review->created_at)->format('M d, Y') }}</li>
							<li class="list-inline-item"><span class="ml-1">-</span>
							<li class="list-inline-item">{{ ucfirst($review->type) }}</a>
						</div>
						<div>
							<li class="list-inline-item">
								@if($ownProfile)<a class="deleteButton" href="" data-toggle="modal" data-target="#deleteModal" data-url="{{ url('review/' . $review->id) }}"><i class="ti-trash mr-2" style="color:red;"></i></a>@endif
							</li>&nbsp;
							<li class="list-inline-item">
								@if($ownProfile)<a href="{{ url('review/' . $review->id . '/edit') }}"><i class="ti-pencil mr-2" style="color:green;"></i></a>@endif
							</li>
						</div>
					</ul>
					<p>Heading example Here is example of hedings. You can use this heading by following markdownify rules. …</p><a href="{{ url('review/' . $review->id) }}" class="btn btn-outline-primary">Continue Reading</a>
				</article>
			</div>
			@endforeach
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
   
<!-- Delete Review Modal -->
<div class="modal fade" id="deleteModal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="deleteForm">
                @method('delete')
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Delete post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border:0;background:transparent;">
                        <span class="ti-close" aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this review?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-danger" value="Delete"></input>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@if($ownProfile)
	<script type="text/javascript" src="{{ url('assets/js/profileImage.js') }}"></script>
	<script type="text/javascript" src="{{ url('assets/js/review-delete-modal.js') }}"></script>
@endif
@endsection