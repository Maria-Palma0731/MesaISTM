<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;

class TicketsTableSeeder extends Seeder
{
    public function run()
    {
        // create tickets attached to existing users
        Ticket::factory(10)->create();
    }
}
