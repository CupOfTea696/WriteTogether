<?php

class GroupsTableSeeder extends Seeder {
    public function run(){
        DB::table('Groups')->delete();
        
        Group::create(["group" => "Admin", "level" => 1]);
        Group::create(["group" => "Moderator", "level" => 2]);
        Group::create(["group" => "User", "level" => 3]);
        
        $this->command->info('Groups table seeded!');
    }
}
