<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StoryStatus extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        
		Schema::dropIfExists('Stories');
        Schema::create('Stories', function($table)
        {
            $table->engine = 'InnoDB';
            
            $table->increments('storyID');
            $table->string('title', 128);
            $table->text('intro');
            $table->text('facts');
            $table->integer('status');
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
        
		Schema::dropIfExists('Stories');
        Schema::create('Stories', function($table)
        {
            $table->engine = 'InnoDB';
            
            $table->increments('storyID');
            $table->string('title', 128);
            $table->text('intro');
            $table->text('facts');
        });
        
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}

}
