<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make(123456789),
            'role' => 1,
        ]);

        $user = User::create([
            'name' => 'demo',
            'email' => 'demo@gmail.com',
            'password' => Hash::make(123456789),
        ]);

        $category = Category::create([
            'name' => 'Std 12',
        ]);

        $question = Question::create([
            'question' => 'this is demo question',
            'added_by' => $user->id,
            'category_id' => $category->id,
            'status' => 1
        ]);

        Answer::create([
            'question_id' => $question->id,
            'answer' => 'Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum generator.',
        ]);

        Answer::create([
            'question_id' => $question->id,
            'answer' => 'Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum generator.',
        ]);
    }
}
