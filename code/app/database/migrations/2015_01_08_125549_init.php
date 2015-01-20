<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Init extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::dropIfExists('Stories');
        Schema::create('Stories', function($table)
        {
            $table->engine = 'InnoDB';
            
            $table->increments('storyID');
            $table->string('title', 128);
            $table->text('intro');
            $table->text('facts');
        });
        
		Schema::dropIfExists('Q');
		Schema::create('Q', function($table)
        {
            $table->engine = 'InnoDB';
            
            $table->increments('qID');
            $table->integer('place');
            $table->string('sessionID', 40);
            $table->integer('storyID')->unsigned();
                $table->foreign('storyID')->references('storyID')->on('Stories')->onDelete('cascade')->onUpdate('cascade');
        });
        
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
        Schema::dropIfExists('Q');
        Schema::dropIfExists('Stories');
        
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}

}
