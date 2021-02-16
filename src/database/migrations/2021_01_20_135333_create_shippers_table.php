<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shippers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order');
            $table->string('type');
            $table->dateTime('time');
            $table->datetime('in')->nullable();
            $table->datetime('out')->nullable();
            $table->string('po')->nullable();
            $table->char('phone',30)->nullable();
            $table->string('email')->nullable();
            $table->integer('location_id');
            $table->bigInteger('load_id');
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
        Schema::dropIfExists('shippers');
    }
}
