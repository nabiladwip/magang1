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
        CREATE TRIGGER id_store BEFORE INSERT ON belis FOR EACH ROW BEGIN
                INSERT INTO belis_table VALUES(NULL);
                SET NEW.notrans = CONCAT("ORDER-", LPAD(LAST_INSERT_ID(), 8, "0"));
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
        DB::unprepared('DROP TRIGGER "id_store"');
    }
};
