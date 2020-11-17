<?php

namespace App\Http\Controllers\Api;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingByReviewShowResource;
use Illuminate\Http\Request;

class BookingByReviewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($reviewKey, Request $request)
    {
        //  ??   means either return a Booking Object using the $reviewKey   or
        //  call   abort(404)   which would return an empty response with a 404 error
        //
        //  return abort(500); 
        $booking = Booking::findByReviewKey($reviewKey);
        return $booking ? new BookingByReviewShowResource($booking) : abort(404);
    }
}
