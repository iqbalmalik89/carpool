<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 150);
            $table->string('last_name', 150);
            $table->string('email', 150);
            $table->string('password', 150);
            $table->string('pic_path', 150)->nullable();
            $table->enum('gender', ['male', 'female'])->default(NULL)->nullable();
            $table->string('city', 150)->nullable();
            $table->string('street_address', 250)->nullable();
            $table->integer('postal_code')->nullable();
            $table->string('country', 150)->nullable();
            $table->string('occupation', 200)->nullable();
            $table->enum('marital_status', ['single', 'married'])->default(NULL)->nullable();
            $table->date('dob')->nullable();
            $table->text('about')->nullable();
            $table->string('mobile', 150);
            $table->enum('status', ['active', 'inactive', 'banned'])->default('active');
            $table->enum('is_verified', ['yes', 'no'])->default('no');
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('site_users');
    }
}
