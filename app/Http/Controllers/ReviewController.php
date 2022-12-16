<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Image;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;
use Response;
use View;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct() {
        $this->middleware('auth', ['except' => ['show']]);
        $this->middleware('own.resource', ['only' => ['edit', 'update', 'destroy']]);
    }
    
    public function deleteImage(Image $image){
        Storage::delete($image->path);
        try{
            $image->delete();
            return back();
        }catch(\Exception $e){
            return back()->withErrors(['imageDeleteError' => 'An error occured deleting your image']);
        }
    }
    
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $admin = null;
        if($request->input('admin')){
            $admin = $request->input('admin');
        }
        $types = Type::all();
        return view('review.create', ['types' => $types]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function saveCarouselImage($review, $carouselImage){
        
        $name = Carbon::now()->format('YmdHisv') . '.' . $carouselImage->extension();
        $path = 'carouselReview-' . $review->id;
        $completePath = Storage::disk('local')->putFileAs(
            $path,
            $carouselImage,
            $name
        );
        $image = new Image();
        $image->path = $completePath;
        $image->idReview = $review->id;
        $image->save();
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => ['required', 'string'],
            'title' => ['required', 'string', 'min:8', 'max:60'],
            'excerpt' => ['required', 'string', 'min:10', 'max:300'],
            'featuredImage' => ['required', 'file', 'max:2048'],
        ]);
        if ($validator->fails()) {
            return back()
            ->withErrors($validator);
        }
        
        if(!Type::where('name', $request->type)->exists()){
           return back()->withErrors(['type' => 'The selected type is invalid']);
        }
        
        $review = new Review($request->all());
        $review->idUser = Auth::user()->id;
        if($request->file('featuredImage')->isValid()) {
            $image = $request->file('featuredImage');
            $path = $image->getRealPath();
            $image = file_get_contents($path);
            $review->featuredImage = base64_encode($image);
        }
        
        try{
            $review->save();
            foreach ($request->carouselImages as $index => $carouselImage){
                $rules['carouselImages.' . $index] = 'required|mimes:png,jpeg,jpg|max:2048';
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return back()
                    ->withErrors(['carouselImages' => 'The carousel images failed to upload.']);
                }else{
                    $this->saveCarouselImage($review, $carouselImage);
                }
            }
            if($request->input('admin')){
                return redirect('admin/review')->with('reviewCreated', 'Your review has been successfully created.');
            }else{
                return redirect('/')->with('reviewCreated', 'Your review has been successfully created.');
            }
        }catch(\Exception $e){
            return back()->withErrors(['reviewCreateError' => 'An error ocurred while creating your review.'])->withInput();
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        return view('review.show', ['review' => $review]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Review $review)
    {
        $admin = null;
        if($request->input('admin')){
            $admin = $request->input('admin');
        }
        $types = Type::all();
        return view('review.edit', ['review' => $review, 'types' => $types, 'admin' => $admin]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        $validator = Validator::make($request->all(), [
            'type' => ['required', 'string', 'in:movie,book,music disc'],
            'title' => ['required', 'string', 'min:8', 'max:60'],
            'excerpt' => ['required', 'string', 'min:10', 'max:300'],
            'featuredImage' => ['file', 'max:2048'],
        ]);
        
        if ($validator->fails()) {
            return back()
            ->withErrors($validator);
        }
        
        if($request->file('featuredImage') && $request->file('featuredImage')->isValid()) {
            $image = $request->file('featuredImage');
            $path = $image->getRealPath();
            $image = file_get_contents($path);
            $review->featuredImage = base64_encode($image);
        }
        $review->type = $request->type;
        $review->title = $request->title;
        $review->excerpt = $request->excerpt;
        $review->content = $request->content;
        
        try{
            $review->update();
            if($request->carouselImages){
                foreach ($request->carouselImages as $index => $carouselImage){
                    $rules['carouselImages.' . $index] = 'required|mimes:png,jpeg,jpg|max:2048';
                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                        return back()
                        ->withErrors(['carouselImages' => 'The carousel images failed to upload.']);
                    }else{
                        $this->saveCarouselImage($review, $carouselImage);
                    }
                }
            }
            if($request->input('admin')){
                return redirect('admin/review')->with('reviewUpdateSuccess', 'Your review has been successfully updated');
            }else{
                return redirect($review->user->name)->with('reviewUpdateSuccess', 'Your review has been successfully updated');
            }
        }catch(\Exception $e){
            return back()->withErrors(['reviewUpdateError' => 'An error occured updating your reivew']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        Storage::deleteDirectory('carouselReview-' . $review->id);
        try{
            $review->delete();
            return back()->with('reviewDeleteSuccess', 'Your review has been successfully deleted');
        }catch(\Exception $e){
            return back()->withErrors(['reviewDeleteError' => 'An error occured deleting your reivew']);
        }
    }
}
