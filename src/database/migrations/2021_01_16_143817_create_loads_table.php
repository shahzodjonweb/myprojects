<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('broker_id');
            $table->string('number');
            $table->integer('price');
            $table->string('status');
            $table->integer('tonu')->nullable()->default(null);
            $table->integer('detention')->nullable()->default(null);
            $table->integer('lumper')->nullable()->default(null);
            $table->string('comment')->nullable()->default(null);
            $table->string('rc')->nullable()->default(null);
            $table->string('invoice')->nullable()->default(null);
            $table->datetime('invoiced_at')->nullable()->default(null);
            $table->datetime('deadline')->nullable()->default(null);

            $table->datetime('started_at')->nullable()->default(null);
            $table->datetime('ended_at')->nullable()->default(null);


            $table->string('bol')->nullable()->default(null);
            $table->string('term')->nullable()->default(null);
            $table->integer('milage');

            $table->integer('deadhead')->nullable()->default(null);
            $table->integer('deadhead_d')->nullable()->default(null);
            $table->bigInteger('driver_id');
            $table->bigInteger('user_id');
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
        Schema::dropIfExists('loads');
    }
}
