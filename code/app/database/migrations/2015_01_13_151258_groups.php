<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Groups extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        
		Schema::dropIfExists('Groups');
		Schema::create('Groups', function($table)
        {
            $table->engine = 'InnoDB';
            
            $table->increments('groupID');
            $table->string('group', 255);
            $table->integer('level');
        });
        
        Schema::dropIfExists('Users');
		Schema::create('Users', function($table)
        {
            $table->engine = 'InnoDB';
            
            $table->increments('userID');
            $table->string('user', 64);
            $table->string('pass', 60);
            $table->integer('passLength');
            $table->string('email', 128);
            $table->string('status', 32);
            $table->integer('groupID')->unsigned();
                $table->foreign('groupID')->references('groupID')->on('Groups')->onDelete('cascade')->onUpdate('cascade');
            $table->rememberToken();
        });
        
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        
        Schema::dropIfExists('Users');
		Schema::create('Users', function($table)
        {
            $table->engine = 'InnoDB';
            
            $table->increments('userID');
            $table->string('user', 64);
            $table->string('pass', 60);
            $table->integer('passLength');
            $table->string('email', 128);
            $table->rememberToken();
        });
        
		Schema::dropIfExists('Groups');
        
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}

}
