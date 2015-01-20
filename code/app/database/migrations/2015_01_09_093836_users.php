<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
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
        
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        
        Schema::dropIfExists('Paragraphs');
        Schema::create('Paragraphs', function($table)
        {
            $table->engine = 'InnoDB';
            
            $table->increments('paragraphID');
            $table->text('paragraph');
            $table->integer('userID')->unsigned();
                $table->foreign('userID')->references('userID')->on('Users')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('storyID')->unsigned();
                $table->foreign('storyID')->references('storyID')->on('Stories')->onDelete('cascade')->onUpdate('cascade');
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
        
		Schema::dropIfExists('Paragraphs');
        Schema::create('Paragraphs', function($table)
        {
            $table->engine = 'InnoDB';
            
            $table->increments('paragraphID');
            $table->text('paragraph');
            $table->string('author', 128);
            $table->integer('storyID')->unsigned();
                $table->foreign('storyID')->references('storyID')->on('Stories')->onDelete('cascade')->onUpdate('cascade');
        });
        
        Schema::dropIfExists('Users');
        
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}

}
