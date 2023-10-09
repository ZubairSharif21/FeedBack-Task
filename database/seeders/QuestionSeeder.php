<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1;$i<10;$i++){
            $question=new Question();
            $question->user_id=1;
            $question->title='Lorem ipsum dolor sit amet consectetur adipisicing elit.';
            $question->description='Lorem ipsum dolor sit amet consecLorem ipsum dolor sit amet consectetur adipisicing elit.';
            $question->save();

        }
    }
}
