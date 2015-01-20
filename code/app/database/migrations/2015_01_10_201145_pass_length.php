<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PassLength extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
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
            $table->string('email', 128);
            $table->rememberToken();
        });
        
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}

}
