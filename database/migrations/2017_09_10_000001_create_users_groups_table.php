<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

  /**
   * Class CreateUsersGroupsTable
   */
class CreateUsersGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //create database
        Schema::create('users_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("user_created_id");
            $table->integer("user_updated_id");
            $table->integer('deleted')->default(0);

            $table->integer("user_id");
            $table->integer("group_id");
            $table->unique(array('user_id','group_id'),'user_id_group_id_unique');

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
        Schema::drop('users_groups');
    }
}
