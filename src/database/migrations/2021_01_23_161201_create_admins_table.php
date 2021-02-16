<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('location')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->text('logo')->nullable();
            $table->string('bank')->nullable();
            $table->string('accounting')->nullable();
            $table->string('routing')->nullable();
            $table->string('mc')->nullable();
            $table->string('dot')->nullable();
            $table->string('invoicenumber');

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
        Schema::dropIfExists('admins');
    }
}
