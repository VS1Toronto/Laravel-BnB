<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->uuid('id')->primary();  //  uuid stands for Universal Unique ID and is a String with a length of thirty six
            $table->timestamps();

            $table->unsignedTinyInteger('rating');
            $table->text('content');

            $table->unsignedBigInteger('bookable_id')->index();
            $table->foreign('bookable_id')->references('id')->on('bookables');

            $table->unsignedBigInteger('booking_id')->index()->nullable();  //  ->nullable makes the relation to the booking optional
            $table->foreign('booking_id')->references('id')->on('bookables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
