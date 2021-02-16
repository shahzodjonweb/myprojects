<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caches', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->datetime('started_at')->nullable()->default(null);
            $table->datetime('ended_at')->nullable()->default(null);

            $table->integer('weekindex')->nullable();
            $table->integer('dispatch_fee')->nullable();

            $table->double('permile')->nullable();
            $table->double('insurance')->nullable();
            $table->double('eld')->nullable();
            $table->double('ifta')->nullable();
            $table->double('lease')->nullable();
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
        Schema::dropIfExists('caches');
    }
}
