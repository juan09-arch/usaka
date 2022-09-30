<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $team = new Team();
        $team->name = "ADI";
        $team->role = "Leader";
        $team->description = "Leading the team";
        $team->save();
    }
}
