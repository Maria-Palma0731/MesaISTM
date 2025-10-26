<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KnowledgeArticle;

class KnowledgeArticlesTableSeeder extends Seeder
{
    public function run()
    {
        KnowledgeArticle::factory(12)->create();
    }
}
