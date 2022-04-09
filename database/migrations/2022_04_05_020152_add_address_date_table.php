<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressDateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
    Schema::table('student', function (Blueprint $table) {
        $table->string('Address', 50)->after('Major')->nullable();
        $table->date('Date_of_Birth')->after('Address')->nullable();
    });
}

/**
 * Reverse the migrations.
 *
 * @return void
 */

    public function down()
    {
    Schema::create('student', function (Blueprint $table) {
    });
}
}