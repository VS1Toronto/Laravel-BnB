<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //-------------------------------------------------------------------------------------------
    //  These are the fields that can be Mass Assigned for this model
    //
    protected $fillable = ['id', 'content', 'rating'];
    //-------------------------------------------------------------------------------------------

    
    public function bookable()
    {
        return $this->belongsTo(Bookable::class);
    }

    
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }


    //-------------------------------------------------------------------------------------------
    //  Here we are telling Laravel that this model
    //  is no longer using a Primary Key that is auto incrementing
    //
    //  getIncrementing()   is a public method defined inside the base model class here we are 
    //  overriding it by redefing it in this Review Class which iS sun class of base model class
    //
    public function getIncrementing()
    {
        //---------------------------------------------------------------------------------------
        //  This tells Laravel its not auto incrementing
        //
        return false;
        //---------------------------------------------------------------------------------------
    }
    //-------------------------------------------------------------------------------------------


    public function getKeyType()
    {
        //---------------------------------------------------------------------------------------
        //  Here we tell Laravel to return a string because we are
        //  using a uuid which is a string and not id which is an integer
        //
        return 'string';
        //---------------------------------------------------------------------------------------
    }
}
