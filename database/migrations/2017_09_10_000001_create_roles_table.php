<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

  /**
   * Class CreateGroupsTable
   */
class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //create database
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("user_created_id");
            $table->integer("user_updated_id");
            $table->integer('deleted')->default(0);

            $table->string('name');
            $table->boolean("status");
            $table->text('description');
            $table->timestamps();
        });
        DB::table('roles')->insert(
            array(
                array(
                    'user_created_id'=>'1',
                    'name'=>'Manager',
                    'status'=>1,
                    'description'=> '',
                ),
            )
        );
        DB::table('roles')->insert(
            array(
                array(
                    'user_created_id'=>'1',

                    'name'=>'Staff',
                    'status'=> 1,
                    'description'=> '',
                ),
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('roles');
    }
}
