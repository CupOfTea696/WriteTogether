<?php

class ParaTableSeeder extends Seeder{
    public function run(){
        DB::table('Paragraphs')->delete();
        
        $stories = Story::all();
        $users = User::orderByRaw("RAND()")->get();
        
        $j=0;
        foreach($stories as $story){
            $j++;
            $i=0;
            
            if($j > WRITE_STORY_AMOUNT)
                break;
            
            foreach($users as $user){
                $i++;
                
                if($i > rand(0,5))
                    continue;
                
                Paragraph::create(["paragraph" => "This is a paragraph. It's funny because it's about your mom. It's funny because she's fat. Also, ur a cunt.", 'userID' => $user->userID, 'storyID' => $story->storyID]);
                
                $story->increment('status');
            }
        }
        
        $this->command->info('Paragraphs table seeded!');
    }
}
