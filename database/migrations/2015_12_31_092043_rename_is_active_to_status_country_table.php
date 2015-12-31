<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameIsActiveToStatusCountryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('country', function($table)
        {
            $table->dropColumn('is_active');
            $table->enum('status', ['active', 'inactive'])->default('inactive');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('country', function($table)
        {
            $table->enum('is_active', ['active', 'inactive'])->default('inactive');
            $table->dropColumn('status');
        });
    }
}
