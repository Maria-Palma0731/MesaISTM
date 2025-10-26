<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\ServicesTableSeeder;
use Database\Seeders\TicketsTableSeeder;
use Database\Seeders\KnowledgeArticlesTableSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            ServicesTableSeeder::class,
            TicketsTableSeeder::class,
            KnowledgeArticlesTableSeeder::class,
        ]);
    }
}
