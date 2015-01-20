<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MailingList extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::dropIfExists('MailingList');
        Schema::create('MailingList', function($table)
        {
            $table->engine = 'InnoDB';
            
            $table->increments('mailID');
            $table->string('email', 128);
        });
        
		Schema::dropIfExists('Subscriptions');
		Schema::create('Subscriptions', function($table)
        {
            $table->engine = 'InnoDB';
            
            $table->increments('subscriptionID');
            $table->integer('mailID')->unsigned();
                $table->foreign('mailID')->references('mailID')->on('MailingList')->onDelete('cascade')->onUpdate('cascade');
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
        
		Schema::dropIfExists('Subscriptions');
        Schema::dropIfExists('MailingList');
        
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}

}
