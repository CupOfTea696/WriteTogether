<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Unsubscribe extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('UnsubLinks');
        Schema::create('UnsubLinks', function($table)
        {
            $table->engine = 'InnoDB';
            
            $table->increments('unsubLinkID');
            $table->string('hash', 32);
            $table->text('string');
            $table->timestamp('created_at');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('UnsubLinks');
	}

}
