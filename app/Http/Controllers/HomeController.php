<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Type;

use Illuminate\Support\Facades\URL;
use Response;

use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
     
    private function getLatestReviews($reviews){
        $reviewCounter = 0;
        $latestReviews = [];
        foreach($reviews as $review){
            if($reviewCounter >= 3){
                break;
            }
            $latestReviews[$reviewCounter] = $review;
            $reviewCounter++;
        }
        return $latestReviews;
    }
    
    private function getCategoriesCount(){
        $types = Type::all();
        $typesCount = [];
        foreach($types as $type){
            $typesCount[$type->name] = count(Review::where('type', $type->name)->get());
        }
        return $typesCount;
        
    }
    
    public function index(Request $request)
    {
        $type = $request->input('type');
        if($type != null){
            if(Type::where('name', $type)->exists()){
                $reviews = Review::where('type', $type)->orderBy('created_at','DESC')->get();
            }else{
                return view('errors.404');
            }
        }else{
            $reviews = Review::orderBy('created_at', 'desc')->get();
        }
        $categoryCount = $this->getCategoriesCount();
        $latestReviews = $this->getLatestReviews($reviews);
        return view('home' , ['reviews' => $reviews, 'latestReviews' => $latestReviews, 'categoryCount' => $categoryCount]);
    }
    
    public function displayCarousel($name, $name2)
    {
        if (!Storage::exists($name . '/' . $name2)) {
            return Response::make('File no found.', 404);
        }

        $file = Storage::get($name . '/' . $name2);
        $type = Storage::mimeType($name . '/' . $name2);
        $response = Response::make($file, 200)->header("Content-Type", $type);

        return $response;
    }
}
