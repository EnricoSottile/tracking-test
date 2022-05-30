<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trackings', function (Blueprint $table) {
            $table->id();
            // in a real case using "unique" may not be scalable 
            // one solution could be to use an index + an expiration date 
            // so that identical tracking codes can live in the same table.
            // another solution could be to have a cron job periodically perform
            // some kind of cleaning or moving of the older tracking codes
            $table->string('tracking_code')->unique();
            $table->datetime('estimated_delivery'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trackings');
    }
};
