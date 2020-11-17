<?php


//--------------------------------------------------------------------------------------------------------
//
//  COMMENTED OUT WHEN ROUTES WHERE CHANGED TO USE NEW BOOKABLE CONTROLLER
//
//  use App\Bookable;
//--------------------------------------------------------------------------------------------------------

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//--------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------
//
//  COMMENTED OUT WHEN ROUTES WHERE CHANGED TO USE NEW BOOKABLE CONTROLLER
//
//--------------------------------------------------------------------------------------------------------
//  http://127.0.0.1:8000/api/bookables   in url bar to test
//
//  Route::get('bookables', function(Request $request) {
//      return Bookable::all();
//  });
//--------------------------------------------------------------------------------------------------------
//
//
//--------------------------------------------------------------------------------------------------------
//  Method   findOrFail()   will find it or fail providing not found code
//
//  To test in Postman apply in Headers tab  :   key    =  accept
//                                               value  =  application/json 
//
//  If the data cannot be retreived on the upper right side it will display   Status 404: Not Found  
//
//  Route::get('bookables/{id}', function (Request $request, $id) {
//      return Bookable::findOrFail($id);
//  });
//--------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------



//--------------------------------------------------------------------------------------------------------
//  API ROUTES FOR BOOKABLE CONTROLLER
//
//  Route::get('bookables', 'Api\BookableController@index');
//  Route::get('bookables/{id}', 'Api\BookableController@show');
//--------------------------------------------------------------------------------------------------------



//--------------------------------------------------------------------------------------------------------------------------
//  API ROUTES FOR BOOKABLE CONTROLLER USING A RESOURCE ROUTE 
//  ->only(['index', 'show']); is also ->name() index and show
//
Route::apiResource('bookables', 'Api\BookableController')->only(['index', 'show']);
//--------------------------------------------------------------------------------------------------------------------------



//--------------------------------------------------------------------------------------------------------------------------
//  API ROUTES FOR BOOKABLE SINGLE ACTION CONTROLLER BOOKABLE AVAILABILITY CONTROLLER
//
Route::get('bookables/{bookable}/availability', 'Api\BookableAvailabilityController')->name('bookables.availability.show');
//--------------------------------------------------------------------------------------------------------------------------



//--------------------------------------------------------------------------------------------------------------------------
//  API ROUTES FOR BOOKABLE SINGLE ACTION CONTROLLER BOOKABLE REVIEWS CONTROLLER
//
Route::get('bookables/{bookable}/reviews', 'Api\BookableReviewController')->name('bookables.reviews.index');
//--------------------------------------------------------------------------------------------------------------------------



//--------------------------------------------------------------------------------------------------------------------------
//  API ROUTES FOR BOOKABLE SINGLE ACTION CONTROLLER BOOKABLE PRICE CONTROLLER
//
Route::get('bookables/{bookable}/price', 'Api\BookablePriceController')->name('bookables.price.show');
//--------------------------------------------------------------------------------------------------------------------------



//--------------------------------------------------------------------------------------------------------------------------
//  API ROUTES FOR BOOKABLE BY REVIEW SINGLE ACTION CONTROLLER BOOKABLE REVIEWS CONTROLLER
//
Route::get('/booking-by-review/{reviewKey}', 'Api\BookingByReviewController')->name('booking.by-review.show');
//--------------------------------------------------------------------------------------------------------------------------


//--------------------------------------------------------------------------------------------------------------------------
//  API ROUTES FOR REVIEW CONTROLLER USING A RESOURCE ROUTE 
//  ->only(['show']); is also ->name('show')
//
Route::apiResource('reviews', 'Api\ReviewController')->only(['show', 'store']);
//--------------------------------------------------------------------------------------------------------------------------


//--------------------------------------------------------------------------------------------------------------------------
//  API ROUTES FOR CHECKOUT SINGLE ACTION CONTROLLER CHECKABLE CONTROLLER
//
Route::post('checkout', 'Api\CheckoutController')->name('checkout');
//--------------------------------------------------------------------------------------------------------------------------
