<?php

namespace Tests\Feature;

use App\Match;
use App\Team;
use App\User;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScoringTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function update_match_scores()
    {
        Passport::actingAs(factory(User::class)->create());

        $team1 = factory(Team::class)->create();
        $team2 = factory(Team::class)->create();

        $match = factory(Match::class)->create([
            "team_1" => $team1->id,
            "team_2" => $team2->id,
            "stage" => "round16",
        ]);

        $scores = [
            "score_1" => 5,
            "score_2" => 3,
        ];

        $response = $this->withoutExceptionHandling()->putJson('api/matches/' . $match->id . '/scores', $scores);
        $response->assertStatus(204); // status updated
        $this->assertEquals(5, $match->fresh()->score_1);
        $this->assertEquals(3, $match->fresh()->score_2);
    }

    /** @test */
    public function scores_should_be_numeric()
    {
        Passport::actingAs(factory(User::class)->create());

        $team1 = factory(Team::class)->create();
        $team2 = factory(Team::class)->create();

        $match = factory(Match::class)->create([
            "team_1" => $team1->id,
            "team_2" => $team2->id,
            "stage" => "round16",
        ]);

        $scores = [
            "score_1" => "not-a-score",
            "score_2" => "not-a-score",
        ];

        $response = $this->putJson('api/matches/' . $match->id . '/scores', $scores);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors("score_1");
        $response->assertJsonValidationErrors("score_2");
    }

    /** @test */
    public function can_determine_winner_via_scores()
    {
        Passport::actingAs(factory(User::class)->create());

        $team1 = factory(Team::class)->create();
        $team2 = factory(Team::class)->create();

        $match = factory(Match::class)->create([
            "team_1" => $team1->id,
            "team_2" => $team2->id,
            "stage" => "round16",
        ]);

        $scores = [
            "score_1" => 1,
            "score_2" => 0,
        ];

        $response = $this->putJson('api/matches/' . $match->id . '/scores', $scores);
        $response->assertStatus(204);
        $this->assertEquals(1, $match->fresh()->winner);
    }

    /** @test */
    public function only_authenticated_user_can_update_scores()
    {
        $team1 = factory(Team::class)->create();
        $team2 = factory(Team::class)->create();

        $match = factory(Match::class)->create([
            "team_1" => $team1->id,
            "team_2" => $team2->id,
            "stage" => "round16",
        ]);

        $scores = [
            "score_1" => 1,
            "score_2" => 0,
        ];

        $response = $this->putJson('api/matches/' . $match->id . '/scores', $scores);
        $response->assertStatus(401);
    }

}
