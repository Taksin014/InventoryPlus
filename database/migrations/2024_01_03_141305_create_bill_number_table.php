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
        DB::unprepared('
            CREATE TRIGGER bill_id BEFORE INSERT ON bills FOR EACH ROW
            BEGIN
                INSERT INTO sequence_bills VALUES (NULL);
                SET NEW.bill_number = CONCAT("BILL_", LPAD(LAST_INSERT_ID(), 8, "0"));
            END
        ');
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER "bill_id"');
    }
};