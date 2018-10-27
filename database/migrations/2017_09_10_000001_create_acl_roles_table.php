<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

  /**
   * Class CreateAclRolesTable
   */
class CreateAclRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //create database
        Schema::create('acl_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("user_created_id");
            $table->integer("user_updated_id");
            $table->integer('deleted')->default(0);

            $table->integer("role_id");
            $table->integer("module_id");
            $table->integer("edit");
            $table->integer("list");
            $table->integer("view");
            $table->integer("delete");
            $table->unique(array('role_id','module_id'),'role_id_module_id_unique');
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
        Schema::drop('acl_roles');
    }
}
