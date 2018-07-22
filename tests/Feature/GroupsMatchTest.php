<?php

namespace Tests\Feature;

use App\Match;
use App\Team;
use App\User;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GroupsMatchTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function get_group_matches()
    {
        $this->markTestSkipped();
        Passport::actingAs(factory(User::class)->create());

        $team1 = factory(Team::class)->create(["group_name" => "Group A", 'country' => 'Belgium', 'team_name' => 'Belgium']);
        $team2 = factory(Team::class)->create(["group_name" => "Group A", 'country' => 'England', 'team_name' => 'England']);
        $team3 = factory(Team::class)->create(["group_name" => "Group A", 'country' => 'Tunisia', 'team_name' => 'Tunisia']);
        $team4 = factory(Team::class)->create(["group_name" => "Group A", 'country' => 'Panama', 'team_name' => 'Panama']);

        $match1 = factory(Match::class)->create([
            "team_1" => $team1->id,
            "team_2" => $team2->id, //here
            "score_1" => 2,
            "score_2" => 1,
        ]);
        $match2 = factory(Match::class)->create([
            "team_1" => $team1->id,
            "team_2" => $team3->id,
            "score_1" => 2,
            "score_2" => 1,
        ]);
        $match3 = factory(Match::class)->create([
            "team_1" => $team1->id,
            "team_2" => $team4->id,
            "score_1" => 2,
            "score_2" => 1,
        ]);

        $match4 = factory(Match::class)->create([
            "team_1" => $team2->id,
            "team_2" => $team3->id,
            "score_1" => 2,
            "score_2" => 1,
        ]);

        $match5 = factory(Match::class)->create([
            "team_1" => $team2->id,
            "team_2" => $team4->id,
            "score_1" => 2,
            "score_2" => 1,
        ]);

        $match6 = factory(Match::class)->create([
            "team_1" => $team3->id,
            "team_2" => $team4->id,
            "score_1" => 2,
            "score_2" => 1,
        ]);


        $response = $this->withoutExceptionHandling()->getJson("api/matches");


        $response->assertSuccessful();
        $this->assertCount(6, $response->json());

    }

    /** @test */
    public function get_elimination_matches()
    {
        Passport::actingAs(factory(User::class)->create());

        $team1 = factory(Team::class)->create(["group_name" => "A", "position" => 1, 'country' => 'Belgium', 'team_name' => 'Belgium']);
        $team2 = factory(Team::class)->create(["group_name" => "A", "position" => 2, 'country' => 'England', 'team_name' => 'England']);
        $team3 = factory(Team::class)->create(["group_name" => "A", "position" => 3, 'country' => 'Tunisia', 'team_name' => 'Tunisia']);
        $team4 = factory(Team::class)->create(["group_name" => "A", "position" => 4, 'country' => 'Panama', 'team_name' => 'Panama']);

        $team5 = factory(Team::class)->create(["group_name" => "B", "position" => 1, 'country' => 'Portugal', 'team_name' => 'Portugal']);
        $team6 = factory(Team::class)->create(["group_name" => "B", "position" => 2, 'country' => 'Spain', 'team_name' => 'Spain']);
        $team7 = factory(Team::class)->create(["group_name" => "B", "position" => 3, 'country' => 'Morocco', 'team_name' => 'Morocco']);
        $team8 = factory(Team::class)->create(["group_name" => "B", "position" => 4, 'country' => 'Iran', 'team_name' => 'Iran']);
        // team 1 - 3 win 0 loss 1
        // team 2 - 2 win 1 loss 2
        // team 3 - 1 win 2 loss 3
        // team 4 - 0 win 3 loss 4
        $response = $this->getJson('api/matches/round16');
        $response->assertSuccessful();
        $response->assertJsonFragment([
            [ 'team_1' => $team1->id, 'team_2' => $team5->id ],
            [ 'team_1' => $team2->id, 'team_2' => $team6->id ], //
        ]);
    }

}
