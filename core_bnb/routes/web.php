<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|------------------------------------------------------------------------------------------------------
| Web Routes
|------------------------------------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//-----------------------------------------------------------------------------------------------------
//  Below replaced with faster routing
//
//  Route::get('/', function () {
//      return view('welcome');
//  });
//
//
//  Route::get('contact', function () {
//      return view('contact');
//  });
//
//
//  Route::get('about', function () {
//      return view('about');
//  });
//-----------------------------------------------------------------------------------------------------



//-----------------------------------------------------------------------------------------------------
//  ROUTES
//
//  First parameter corresponds to url 
//  Second Parameter corresponds to view
//
//  This is single line notation for routes which is good for cleanliness of code
//


//  FALLBACK ROUTE
//
//  This route if active contais a regular expression which contains shortened code symbols
//  to represent Regex strings and will match any word typed in as a route and return the route
//  to view home as long as you dont type in the word api
//
//  Route::get('/{any?}', function () {
//      return view('home');
//  })->where('any', '^(?!api\/)[\/\w\.-]*');


//Route::view('/', 'home')->name('home');
//Route::view('contact', 'contact')->name('contact');
//Route::view('about', 'about')->name('about');
//-----------------------------------------------------------------------------------------------------


Auth::routes();


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/{any?}', function () {
    return view('index');
})->where('any', '^(?!api\/)[\/\w\.-]*');



//Reoptimized class loader:
// Route::get('optimize', function() {
//     Artisan::call('optimize');
//     return '<h1>Reoptimized class loader</h1>';
// });



// clear application cache:
//
// Route::get('clear-cache', function() {
//     Artisan::call('cache:clear');
//     return "<h1>Application cache flushed</h1>";
// });



//-----------------------------------------------------------------------------------------------------
//  ROUTES TO OPERATE ARTISAN ON SHARED SERVER
//


//  Clear Route cache:
//
// Route::get('route-clear', function() {
//     Artisan::call('route:clear');
//     return '<h1>Route cache cleared</h1>';
// });


//  Clear View cache:
//
// Route::get('view-clear', function() {
//     Artisan::call('view:clear');
//     return '<h1>View cache cleared</h1>';
// });


//  Clear Config cache:
//
// Route::get('config-cache', function() {
//     Artisan::call('config:cache');
//     return '<h1>Clear Config cleared</h1>';
// });


//  Route cache:
//
// Route::get('route-cache', function() {
//     Artisan::call('route:cache');
//     return '<h1>Routes cached</h1>';
// });

//-----------------------------------------------------------------------------------------------------



//Route::get('/home', 'HomeController@index')->name('home');
