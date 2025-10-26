<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\KnowledgeArticle;
use App\Models\User;

class KnowledgeArticleFactory extends Factory
{
    protected $model = KnowledgeArticle::class;

    public function definition()
    {
        return [
            'author_id' => User::factory(),
            'title' => fake()->sentence(6),
            'content' => fake()->paragraphs(3, true),
            'published' => fake()->boolean(70),
        ];
    }
}
