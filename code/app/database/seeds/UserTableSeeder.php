<?php

class UserTableSeeder extends Seeder{
    public function run(){
        DB::table('Users')->delete();
        
        User::create([
            "user" => "admin",
            "pass" => Hash::make('Admin123'),
            'email' => 'admin@writetogeth.er',
            'passLength' => strlen('Admin123'),
            'status' => 'ok',
            'groupID' => Group::where('group', 'Admin')->first()->groupID
        ]);
        User::create([
            "user" => "moderator",
            "pass" => Hash::make('Moderator123'),
            'email' => 'moderator@writetogeth.er',
            'passLength' => strlen('Moderator123'),
            'status' => 'ok',
            'groupID' => Group::where('group', 'Moderator')->first()->groupID
        ]);
        User::create([
            "user" => "user",
            "pass" => Hash::make('User123'),
            'email' => 'user@writetogeth.er',
            'passLength' => strlen('User123'),
            'status' => 'ok',
            'groupID' => Group::where('group', 'User')->first()->groupID
        ]);
        User::create([
            "user" => "dummy",
            "pass" => Hash::make('Dummy123'),
            'email' => 'user@writetogeth.er',
            'passLength' => strlen('Dummy123'),
            'status' => 'deleted:2015-02-13', // recover available until 2015-02-13
            'groupID' => Group::where('group', 'User')->first()->groupID
        ]);
        User::create([
            "user" => "dummy4",
            "pass" => Hash::make('Dummy456'),
            'email' => 'user@writetogeth.er',
            'passLength' => strlen('Dummy123'),
            'status' => 'blocked:192.168.1.1', // bad boi. permanently blocked, by IP as well.
            'groupID' => Group::where('group', 'User')->first()->groupID
        ]);
        User::create([
            "user" => "dummy7",
            "pass" => Hash::make('Dummy789'),
            'email' => 'user@writetogeth.er',
            'passLength' => strlen('Dummy123'),
            'status' => 'disabled:2015-02-13', // blocked until date (decided by admin / defined by rule)
            'groupID' => Group::where('group', 'User')->first()->groupID
        ]);
        User::create([
            "user" => "dummy10",
            "pass" => Hash::make('Dummy101112'),
            'email' => 'user@writetogeth.er',
            'passLength' => strlen('Dummy101112'),
            'status' => 'ok', // an angel that has done nothing wrong!
            'groupID' => Group::where('group', 'User')->first()->groupID
        ]);
        
        $this->command->info('User table seeded!');
    }
}
