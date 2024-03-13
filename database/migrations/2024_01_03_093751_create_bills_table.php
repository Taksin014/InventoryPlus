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
        Schema::create('bills', function (Blueprint $table) {
            $table->id('bill_id');
            $table->string('bill_number');
            $table->string('requester')->nullable();
            $table->string('user_id')->nullable();
            $table->string('company')->nullable();
            $table->string('age_id')->nullable();
            $table->string('bill_date')->nullable();
            $table->string('state')->nullable()->default('Pending');
            $table->string('acu_id')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('bills');
    }
};
