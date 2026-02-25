<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedBigInteger('plan_id');
            $table->unsignedBigInteger('trainer_id');
            $table->dateTime('scheduled_at');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('plan_id')->references('id')->on('plans')->cascadeOnDelete();
            $table->foreign('trainer_id')->references('id')->on('trainers')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
