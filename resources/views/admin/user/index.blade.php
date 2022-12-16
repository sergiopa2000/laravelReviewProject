@extends('layouts.app')
@section('styles')
<link rel="stylesheet" href="{{ url('assets/css/dashboard.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ url('assets/css/app.css')}}" type="text/css"/>
<style>
    .container{
        max-width: unset;
        padding: 0;
    }
    
    .navbar, footer{
        padding: 8px 10%;
    }
    
    a{
        text-decoration: none !important;
    }
    
    th{
        font-weight: 800 !important; 
    }
    
    td, th{
        text-align: center;
    }
    
    .sidebar-brand{
        padding-top: 40px !important;
    }
    
    .ti-trash, .ti-pencil{
        cursor: pointer;
        font-size: 2em;
    }
</style>
@endsection
@section('content')
	<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="index.html">
          <span class="align-middle">Admin Dashboard</span>
        </a>

				<ul class="sidebar-nav">
					<li class="sidebar-header">
						Resources
					</li>

					<li class="sidebar-item active">
						<a class="sidebar-link" href="{{ url('admin/user') }}">
              <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Users</span>
            </a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="{{ url('admin/review') }}">
              <i class="align-middle" data-feather="user"></i> <span class="align-middle">Review</span>
            </a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="{{ url('admin/type') }}">
              <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Types</span>
            </a>
				</ul>
			</div>
		</nav>

		<div class="main">
			<main class="content" style="padding: 10px;">
				<div class="container-fluid p-0">
					<div class="row" style="width: 100%;margin: 0;">
					    @if(session('userDeleteSuccess'))
					        <div class="alert alert-success">{{ session('userDeleteSuccess') }}</div>
					    @endif
					    @error('userDeleteError')
					        <div class="alert alert-danger">{{ $message }}</div>
					    @enderror
					    
					    @if(session('userUpdateSuccess'))
					        <div class="alert alert-success">{{ session('userUpdateSuccess') }}</div>
					    @endif
					    @error('userUpdateError')
					        <div class="alert alert-danger">{{ $message }}</div>
					    @enderror
					    
			           @if(session('userCreated'))
                          <div class="alert alert-success">{{ session('userCreated') }}</div>
                       @endif
                       @error('userCreateError')
                          <div class="alert alert-danger">{{ $message }}</div>
                       @enderror
						<div class="col-12 col-lg-8 col-xxl-9 d-flex" style="width: 100%;padding: 0;">
							<div class="card flex-fill">
								<table class="table table-hover my-0">
									<thead>
										<tr>
											<th>Id</th>
											<th class="d-none d-xl-table-cell">Name</th>
											<th class="d-none d-xl-table-cell">Email</th>
											<th>Verified</th>
											<th>Admin</th>
											<th class="d-none d-md-table-cell">Account date</th>
											<th class="d-none d-md-table-cell">Delete</th>
											<th class="d-none d-md-table-cell">Edit</th>
										</tr>
									</thead>
									<tbody>
									    @foreach($users as $user)
										<tr>
										    <td>{{ $user->id }}</td>
											<td>{{ $user->name }}</td>
											<td class="d-none d-xl-table-cell">{{ $user->email }}</td>
											@if($user->email_verified_at == null)
											    <td><span class="badge bg-danger">No</span></td>
											@else
											    <td><span class="badge bg-success">Yes</span></td>
											@endif
											@if($user->isAdmin == 0)
											    <td><span class="badge bg-danger">No</span></td>
											@else
											    <td><span class="badge bg-success">Yes</span></td>
											@endif
											<td class="d-none d-md-table-cell">{{ $user->created_at }}</td>
											@if($user->id != Auth::user()->id)
											    <td class="d-none d-md-table-cell"><a class="deleteButton" href="" data-toggle="modal" data-target="#deleteModal" data-url="{{ url($user->name) }}" data-name="{{ $user->name }}"><i class="ti-trash mr-2" style="color:red;"></i></a></td>
    				    					    <td class="d-none d-md-table-cell"><a href="{{ url('admin/user/' . $user->name . '/edit') }}"><i class="ti-pencil mr-2" style="color:green;"></i></a></td>
											@else
											    <td class="d-none d-md-table-cell"></td>
					    					    <td class="d-none d-md-table-cell"><a href="{{ url($user->name) }}"><i class="ti-pencil mr-2" style="color:green;"></i></a></td>
											@endif
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<a href="{{ url('admin/user/create') }}" class="btn btn-primary" style="margin-top: 10px;">New User</a>

				</div>
			</main>
		</div>
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
<!-- Delete User Modal -->
<div class="modal fade" id="deleteModal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="deleteForm">
                @method('delete')
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Delete user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border:0;background:transparent;">
                        <span class="ti-close" aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this user?</p>
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
    <script type="text/javascript" src="{{ url('assets/js/review-delete-modal.js') }}"></script>
@endsection