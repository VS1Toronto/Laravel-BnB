<?php

namespace App\Http\Controllers\Api;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function show($id)
    {
        return new ReviewResource(Review::findOrFail($id));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            //  This is referencing a uuid which is of type String and has 36 characters in the database
            //
            'id' => 'required|size:36|unique:reviews',      //  unique:reviews   checks to see if the review already exists    
            'content' => 'required|min:2',
            'rating' => 'required|in:1,2,3,4,5'
        ]);


        //---------------------------------------------------------------------------------------------------------------------------------------
        //  SAVE BOOKING TO DATABASE
        //
        //  Find with validated id and store the booking data in this variable
        //
        $booking = Booking::findByReviewKey($data['id']);


        //  If theres no booking that has this review key anymore 
        //  that means the review was already stored for this booking
        //
        if (null === $booking) {
            return abort(404);
        }


        //  If there is still a booking with this review key in the Bookings table we will
        //  take it away leaving an empty String so that the user cannot leave a second review
        //
        $booking->review_key = '';

        $booking->save();
        //---------------------------------------------------------------------------------------------------------------------------------------





        //---------------------------------------------------------------------------------------------------------------------------------------
        //  SAVE REVIEW OF BOOKING TO DATABASE
        //
        //  The last step here is to create a review
        //
        $review = Review::make($data);

        //  These steps are to set these ids ourselves here so no malicious user can try to
        //
        $review->booking_id = $booking->id;
        $review->bookable_id = $booking->bookable_id;

        $review->save();
        //---------------------------------------------------------------------------------------------------------------------------------------
    

        
        //  Use Resource to return new review with only limited data instead of it all
        //
        return new ReviewResource($review);

    }
}
