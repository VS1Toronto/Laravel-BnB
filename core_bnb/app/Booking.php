<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    //---------------------------------------------------------------------------------------------------
    //  MASS ASSIGNMENT
    //
    //  The default settings on Laravel prevent Mass Assignment of all properties of an object
    //  at once so here we have to tell Laravel which properties are allowed to be Mass Assigned
    //  this prevents anyone either accidentally or maliciously saving a new value for other properties
    //
    protected $fillable = ['from', 'to'];
    //---------------------------------------------------------------------------------------------------


    public function bookable()
    {
        return $this->belongsTo(Bookable::class);
    }


    public function review()
    {
        return $this->hasOne(Review::class);
    }


    public function address()
    {
        return $this->belongsTo(Address::class);
    }


    //---------------------------------------------------------------------------------------------------
    //  LOCAL QUERY SCOPE TO FILTER QUERY THIS IS CALLED BY IGNORING THE
    //  scope KEYWORD AND CALLING THE METHOD WITH A LOWERCASE FIRST LETTER
    //  EXAMPLE CALLED FROM BOOKABLE AVAILABILITY CONTROLLER   ->betweenDates()
    //
    public function scopeBetweenDates(Builder $query, $from, $to)
    {
        return $query->where('to', '>=', $from)
            ->where('from', '<=', $to);
    }
    //---------------------------------------------------------------------------------------------------


    //---------------------------------------------------------------------------------------------------
    //  STATIC FUNCTION findByReviewKey()
    //
    //  Since Php 7.1 you can define a return type on functions   : ?Booking   like this
    //  This means that you always expect the   Booking Class   to be returned from this
    //  function and this would fail if it doesnt
    //
    //  The   ?   means that either you expect the   Booking Class   to be returned or   null   returned
    //
    public static function findByReviewKey(string $reviewKey): ?Booking
    {
        //  EAGER LOADING
        //
        //  Return this object using a query WHERE 'review_key' = $reviewKey together with a relation
        //
        return static::where('review_key', $reviewKey)->with('bookable')->get()->first();
    }
    //---------------------------------------------------------------------------------------------------


    //---------------------------------------------------------------------------------------------------
    //  BOOT FUNCTION
    //
    //  This method is defined in the parent class Model
    //  This initialises how an Eloquent static Model should behave
    //
    protected static function boot()
    {
        parent::boot();     //  You have to do this if you override this method
    
        //-----------------------------------------------------------------------------------------------
        //  To register an event you call static:: which refers to this class statically
        //
        //  Inside this closure there is specific handling that happens when this Model is created
        //
        static::creating(function($booking) {
            $booking->review_key = Str::uuid(); //  review_key assigned to any created Booking Model 
        });
        //-----------------------------------------------------------------------------------------------
    }
    //---------------------------------------------------------------------------------------------------

}
