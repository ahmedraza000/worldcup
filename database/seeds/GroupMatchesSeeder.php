<?php

use Illuminate\Database\Seeder;

class GroupMatchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed Teams;
        $team1 = factory(\App\Team::class)->create([
            "team_name" => "Russia",
            "country" => "Country",
            "group_name" => "A",
            "position" => 1,
        ]);
        $team2 = factory(\App\Team::class)->create([
            "team_name" => "Sweden",
            "country" => "Country",
            "group_name" => "A",
            "position" => 2,
        ]);
        $team3 = factory(\App\Team::class)->create([
            "team_name" => "Italy",
            "country" => "Country",
            "group_name" => "A",
            "position" => 3,
        ]);
        $team4 = factory(\App\Team::class)->create([
            "team_name" => "France",
            "country" => "Country",
            "group_name" => "A",
            "position" => 4,
        ]);

        $team5 = factory(\App\Team::class)->create([
            "team_name" => "Brazil",
            "country" => "Country",
            "group_name" => "B",
            "position" => 1,
        ]);
        $team6 = factory(\App\Team::class)->create([
            "team_name" => "Spain",
            "country" => "Country",
            "group_name" => "B",
            "position" => 2,
        ]);
        $team7 = factory(\App\Team::class)->create([
            "team_name" => "Iran",
            "country" => "Country",
            "group_name" => "B",
            "position" => 3,
        ]);
        $team8 = factory(\App\Team::class)->create([
            "team_name" => "Turkey",
            "country" => "Country",
            "group_name" => "B",
            "position" => 4,
        ]);

        // Seed Group Matches with complete scoring and ranking
        factory(\App\Match::class)->create([
            "team_1" => $team1->id,
            "team_2" => $team2->id,
            "score_1" => 1,
            "score_2" => 0,
            "winner" => $team1->id,
            "stage" => "group",
        ]);
        factory(\App\Match::class)->create([
            "team_1" => $team1->id,
            "team_2" => $team3->id,
            "score_1" => 1,
            "score_2" => 2,
            "winner" => $team3->id,
            "stage" => "group",
        ]);
        factory(\App\Match::class)->create([
            "team_1" => $team1->id,
            "team_2" => $team4->id,
            "score_1" => 1,
            "score_2" => 4,
            "winner" => $team4->id,
            "stage" => "group",
        ]);
        factory(\App\Match::class)->create([
            "team_1" => $team2->id,
            "team_2" => $team3->id,
            "score_1" => 5,
            "score_2" => 4,
            "winner" => $team2->id,
            "stage" => "group",
        ]);
        factory(\App\Match::class)->create([
            "team_1" => $team2->id,
            "team_2" => $team4->id,
            "score_1" => 5,
            "score_2" => 4,
            "winner" => $team2->id,
            "stage" => "group",
        ]);
        factory(\App\Match::class)->create([
            "team_1" => $team3->id,
            "team_2" => $team4->id,
            "score_1" => 6,
            "score_2" => 4,
            "winner" => $team3->id,
            "stage" => "group",
        ]);
        factory(\App\Match::class)->create([
            "team_1" => $team5->id,
            "team_2" => $team6->id,
            "score_1" => 6,
            "score_2" => 4,
            "winner" => $team5->id,
            "stage" => "group",
        ]);
        factory(\App\Match::class)->create([
            "team_1" => $team5->id,
            "team_2" => $team7->id,
            "score_1" => 6,
            "score_2" => 7,
            "winner" => $team7->id,
            "stage" => "group",
        ]);
        factory(\App\Match::class)->create([
            "team_1" => $team5->id,
            "team_2" => $team8->id,
            "score_1" => 1,
            "score_2" => 4,
            "winner" => $team8->id,
            "stage" => "group",
        ]);
        factory(\App\Match::class)->create([
            "team_1" => $team6->id,
            "team_2" => $team7->id,
            "score_1" => 1,
            "score_2" => 4,
            "winner" => $team7->id,
            "stage" => "group",
        ]);
        factory(\App\Match::class)->create([
            "team_1" => $team6->id,
            "team_2" => $team8->id,
            "score_1" => 6,
            "score_2" => 3,
            "winner" => $team6->id,
            "stage" => "group",
        ]);
        factory(\App\Match::class)->create([
            "team_1" => $team7->id,
            "team_2" => $team8->id,
            "score_1" => 6,
            "score_2" => 5,
            "winner" => $team7->id,
            "stage" => "group",
        ]);
    }
}
