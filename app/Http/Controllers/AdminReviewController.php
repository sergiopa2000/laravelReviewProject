<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Review;

use Hash;

class AdminReviewController extends Controller
{
    function __construct() {
        $this->middleware('admin');
    }
    
    public function index(){
        $reviews = Review::all();
        return view('admin.review.index', ['reviews' => $reviews]);
    }
    
    public function create()
    {
        
    }

    
    public function store(Request $request)
    {

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        
    }
}
