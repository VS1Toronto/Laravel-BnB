<?php

namespace App\Http\Controllers\Api;

use App\Bookable;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookableReviewIndexResource;
use Illuminate\Http\Request;

class BookableReviewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id, Request $request)
    {
        //---------------------------------------------------------------------------------------------------------------------------
        //  Calling the   request()   method is the same as passing   Request $request   as a parameter in the methods parenthisis   
        //
        //---------------------------------------------------------------------------------------------------------------------------
    


        //---------------------------------------------------------------------------------------------------------------------------
        //  First we find the Bookable object which the parameter $id to refers to then we return the reviews
        //
        $bookable = Bookable::findOrFail($id);

        //  return $bookable->reviews()->latest()->get();   //  This works because we have a defined relationship between the models#
        //                                                  //  latest()   sorts from the newest first
        //                                                  //  get()   has to be called at the end to execute the query
        
        //  Changed to this from above to use static collection method
        //
        return BookableReviewIndexResource::collection(
            $bookable->reviews()->latest()->get()
        );
        //---------------------------------------------------------------------------------------------------------------------------
    }
}
