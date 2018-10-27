<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

  /**
   * Class CreateGroupsTable
   */
class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //create database
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("user_created_id");
            $table->integer("user_updated_id");
            $table->integer('deleted')->default(0);

            $table->string('name');
            $table->boolean("status");
            $table->text('description');
            $table->integer("parent_group_id")->default(0);
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
        Schema::drop('groups');
    }
}
