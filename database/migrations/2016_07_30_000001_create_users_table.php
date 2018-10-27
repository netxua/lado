  <?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

  /**
   * Class CreateUsersTable
   */
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //create database
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("user_created_id");
            $table->integer("user_updated_id");
            $table->integer('deleted')->default(0);
            $table->rememberToken("remember_token");
            $table->string("avatar");
            $table->string("username")->unique();
            $table->string("email")->unique();
            $table->string("password");
            $table->string('name');
            $table->boolean("status");
            $table->integer("role_id")->default(0);
            $table->integer("is_admin")->default(0);
            $table->string('login_ip');
            $table->timestamps();
        });
        //insert database
        DB::table('users')->insert(
            array(
                array(
                    'user_created_id'=>'0',
                    'username'=>'admin',
                    'email' => 'admin',
                    'password' => \Hash::make('admin'),
                    'name'=>'admin',
                    'avatar'=>'',
                    'status'=>1,
                    'role_id'=>0,
                    'is_admin'=>1,
                ),
            )
        );
        DB::table('users')->insert(
            array(
                array(
                    'user_created_id'=>'0',
                    'username'=>'manager',
                    'email' => 'manager',
                    'password' => \Hash::make('123456'),
                    'name'=>'manager',
                    'avatar'=>'',
                    'status'=>1,
                    'role_id'=>0,
                    'is_admin'=>0,
                ),
            )
        );
        DB::table('users')->insert(
            array(
                array(
                    'user_created_id'=>'0',
                    'username'=>'staff',
                    'email' => 'staff',
                    'password' => \Hash::make('123456'),
                    'name'=>'staff',
                    'avatar'=>'',
                    'status'=>1,
                    'role_id'=>0,
                    'is_admin'=>0,
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
        Schema::drop('users');
    }
}
