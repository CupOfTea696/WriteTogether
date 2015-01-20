<?php

class StoryTableSeeder extends Seeder{
    public function run(){
        DB::table('Stories')->delete();
        
        $s = Story::create(["title" => "The Giant Dragon", "intro" => 'Once upon a time there was a giant dragon named Thomas. He was very strong and powerful. He also was a cunt.', 'facts' => json_encode(['Dragon color: black', 'Dragon name: Thomas', 'Dragon occupation: dentist', 'Country: Egypt'])]);
        if(!in_array(to_dash_case($s->title) . '@writetogether.cupoftea.io', Mailgun::lists()->all()->lists('address'))){
            Mailgun::lists()->create([
                'address' => to_dash_case($s->title) . '@writetogether.cupoftea.io',
                'name' => $s->title
            ]);
        }
        
        $s = Story::create(["title" => "another", "intro" => 'yeah no not actually a story just a test', 'facts' => json_encode(['No facts given. Go Wild!'])]);
        if(!in_array(to_dash_case($s->title) . '@writetogether.cupoftea.io', Mailgun::lists()->all()->lists('address'))){
            Mailgun::lists()->create([
                'address' => to_dash_case($s->title) . '@writetogether.cupoftea.io',
                'name' => $s->title
            ]);
        }
        
        $s = Story::create(["title" => "This Is the Test Bruh", "intro" => 'also not a story.', 'facts' => json_encode(['also no facts'])]);
        if(!in_array(to_dash_case($s->title) . '@writetogether.cupoftea.io', Mailgun::lists()->all()->lists('address'))){
            Mailgun::lists()->create([
                'address' => to_dash_case($s->title) . '@writetogether.cupoftea.io',
                'name' => $s->title
            ]);
        }
        
        $s = Story::create(["title" => "I pooped in your pants", "intro" => 'sorry.', 'facts' => json_encode(['pants: yours', 'poop: mine'])]);
        if(!in_array(to_dash_case($s->title) . '@writetogether.cupoftea.io', Mailgun::lists()->all()->lists('address'))){
            Mailgun::lists()->create([
                'address' => to_dash_case($s->title) . '@writetogether.cupoftea.io',
                'name' => $s->title
            ]);
        }
        
        $s = Story::create(["title" => "Looking For Alaska In My Pants", "intro" => '404 Alaska not found.', 'facts' => json_encode(['I really wanted her in my pants'])]);
        if(!in_array(to_dash_case($s->title) . '@writetogether.cupoftea.io', Mailgun::lists()->all()->lists('address'))){
            Mailgun::lists()->create([
                'address' => to_dash_case($s->title) . '@writetogether.cupoftea.io',
                'name' => $s->title
            ]);
        }
        
        $s = Story::create(["title" => "tHAT wAS aN eNTIRE sTORY", "intro" => 'the alaska one', 'facts' => json_encode(['title: Looking For Alaska In My Pants'])]);
        if(!in_array(to_dash_case($s->title) . '@writetogether.cupoftea.io', Mailgun::lists()->all()->lists('address'))){
            Mailgun::lists()->create([
                'address' => to_dash_case($s->title) . '@writetogether.cupoftea.io',
                'name' => $s->title
            ]);
        }
        
        $this->command->info('Story table seeded!');
    }
}
