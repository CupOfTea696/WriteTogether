<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
        
        $this->call('GroupsTableSeeder');
		$this->call('UserTableSeeder');
		$this->call('StoryTableSeeder');
		$this->call('ParaTableSeeder');
	}

}
