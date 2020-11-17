<?php

use App\Bookable;
use App\Booking;
use Illuminate\Database\Seeder;

class BookingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bookable::all()->each(function (Bookable $bookable) {
            $booking = factory(Booking::class)->make();
            $bookings = collect([$booking]);    //  Create this collection so we can save all bookings at once at end

            //------------------------------------------------------------------------------------------------------------
            //  Generate between 1 and 20 bookings for each Bookable object
            //
            for($i = 0; $i < random_int(1, 20); $i++) {

                //--------------------------------------------------------------------------------------------------------
                //  Generate unique dates for all the bookings
                //
                $from = (clone $booking->to)->addDays(random_int(1, 14));   //  Make sure each date starts a day later
                $to = (clone $from)->addDays(random_int(0, 14));            //  Make to date a maximum of 14 days after
                //--------------------------------------------------------------------------------------------------------
            
                //--------------------------------------------------------------------------------------------------------
                //  Assign to Booking again because we are making a brand new booking model
                //
                $booking = Booking::make([
                    'from' => $from,
                    'to' => $to,
                    'price' => random_int(200, 5000)
                ]);
                $bookings->push($booking);
                //--------------------------------------------------------------------------------------------------------        
            }   
            //  End For Loop
            //------------------------------------------------------------------------------------------------------------

            //------------------------------------------------------------------------------------------------------------
            //  Save all Bookings at once so that we save some processing time by avoiding 
            //  lots of queries that would occur if we saved each booking each time it was created
            //
            $bookable->bookings()->saveMany($bookings);
            //------------------------------------------------------------------------------------------------------------
        
        });
    }
}
