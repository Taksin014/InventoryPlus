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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('CODE_COMBINATION_ID')->nullable();
            $table->string('SEGMENT1')->nullable();
            $table->string('SEGMENT2')->nullable();
            $table->string('SEGMENT3')->nullable();
            $table->string('SEGMENT4')->nullable();
            $table->string('SEGMENT5')->nullable();
            $table->string('SEGMENT6')->nullable();
            $table->string('SEGMENT7')->nullable();
            $table->string('SEGMENT8')->nullable();
            $table->string('SEGMENT1_DESC')->nullable();
            $table->string('SEGMENT2_DESC')->nullable();
            $table->string('SEGMENT3_DESC')->nullable();
            $table->string('SEGMENT4_DESC')->nullable();
            $table->string('SEGMENT5_DESC')->nullable();
            $table->string('SEGMENT6_DESC')->nullable();
            $table->string('SEGMENT7_DESC')->nullable();
            $table->string('SEGMENT8_DESC')->nullable();
            $table->string('CHART_OF_ACCOUNTS_ID')->nullable();
            $table->string('ACCOUNT_TYPE')->nullable();
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
        Schema::dropIfExists('accounts');
    }
};
