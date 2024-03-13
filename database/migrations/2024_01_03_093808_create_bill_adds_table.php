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
        Schema::create('bill_adds', function (Blueprint $table) {
            $table->id ('bill_line_id');
            $table->string('bill_number');
            $table->string('item_id')->nullable();
            $table->string('depart_id')->nullable();
            $table->string('qty')->nullable();
            $table->string('desc')->nullable();
            $table->string('reason_code')->nullable();
            $table->string('segment_desc')->nullable();
            $table->string('acc_desc')->nullable();
            $table->string('segment')->nullable();
            $table->string('chart')->nullable();
            $table->string('state')->nullable()->default('Pending');
            $table->string('verify')->nullable()->default('Pending');
            $table->string('dispense')->nullable()->default('Wait');
            $table->string('investor')->nullable();
            $table->string('receiver')->nullable();
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
        Schema::dropIfExists('bills_adds');
    }
};
