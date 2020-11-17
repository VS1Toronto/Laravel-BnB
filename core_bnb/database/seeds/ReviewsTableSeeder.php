<?php

use App\Bookable;
use App\Review;
use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        //  Get all the bookables with all() then use each() to iterate over them using a closure
        //
        Bookable::all()->each(function (Bookable $bookable) {
            
            //-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
            //  Generate some reviews using ReviewFactory
            //
            $reviews = factory(Review::class, random_int(5, 30))->make();   //  Use random_int() to generate between 5 and 30 reviews and use make() to create instances of thos models

            $bookable->reviews()->saveMany($reviews);
            //-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        });
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    }
}
