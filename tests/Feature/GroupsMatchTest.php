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

   /* /** @test */
    public function groups_matches_score_test()
    {
        $this->markTestSkipped();
//        Group G:
//1.	Belgium                                  Belgium will be player 3 matches in groups
//2.	England                                  England will be play 3 matches in the groups
//3.	Tunisia                                   ----------------------
//4.	Panama                            ---------------------
        $team1 = factory(Team::class)->create(['country' => 'Belgium', 'team_name' => 'Belgium']);
        $team2 = factory(Team::class)->create(['country' => 'England', 'team_name' => 'England']);
        $team3 = factory(Team::class)->create(['country' => 'Tunisia', 'team_name' => 'Tunisia']);
        $team4 = factory(Team::class)->create(['country' => 'Panama', 'team_name' => 'Panama']);

        $match = factory(Match::class)->create([
            'team1' => $team1->id,
            'team2' => $team2->id,
            'schedule' => '06-14-2018',
            'score1' => 2,
            'score2' => 1,

        ]);
    }

    /** @test */
    public function get_group_matches()
    {
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
    public function get_stage_matches()
    {

        Passport::actingAs(factory(User::class)->create());

        $team1 = factory(Team::class)->create(["group_name" => "Group A", 'country' => 'Belgium', 'team_name' => 'Belgium']);
        $team2 = factory(Team::class)->create(["group_name" => "Group A", 'country' => 'England', 'team_name' => 'England']);
        $team3 = factory(Team::class)->create(["group_name" => "Group A", 'country' => 'Tunisia', 'team_name' => 'Tunisia']);
        $team4 = factory(Team::class)->create(["group_name" => "Group A", 'country' => 'Panama', 'team_name' => 'Panama']);
        // team 1 - 3 win 0 loss
        // team 2 - 2 win 1 loss
        // team 3 - 1 win 2 loss
        // team 4 - 0 win 3 loss
        $match1 = factory(Match::class)->create([
            "team_1" => $team1->id,
            "team_2" => $team2->id,
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

        $response = $this->getJson('api/matches/stage/1');
        $this->assertCount('');
    }

}
