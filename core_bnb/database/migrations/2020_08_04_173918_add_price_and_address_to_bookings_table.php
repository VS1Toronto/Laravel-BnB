<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceAndAddressToBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedInteger('price');

            //-------------------------------------------------------------------------------------
            //  This relationship is added to the   bookings   table because the booking will
            //  always have one address the address that was given at the time of the booking
            //  whereas the addresses table may be used for multiple things which may make things
            //  complicated if we establish the relationship there
            //
            $table->unsignedBigInteger('address_id')->index()->nullable();
            $table->foreign('address_id')->references('id')->on('addresses');
            //-------------------------------------------------------------------------------------
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('price');

            
            //-------------------------------------------------------------------------------------
            //  Using [] brackets here with   ['address_id']   has Laravel give the foreign key
            //  a name which means we can just use this   ['address_id']   and Laravel will know
            //  what this references
            //
            $table->dropForeign(['address_id']);
            $table->dropColumn('address_id');
            //-------------------------------------------------------------------------------------
        });
    }
}