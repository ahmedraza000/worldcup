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
        $team9 = factory(Team::class)->create(["group_name" => "C", "position" => 3, 'country' => 'Sweden', 'team_name' => 'Belgium']);
        $team10 = factory(Team::class)->create(["group_name" => "C", "position" => 2, 'country' => 'Denmark', 'team_name' => 'England']);
        $team11 = factory(Team::class)->create(["group_name" => "C", "position" => 1, 'country' => 'Norway', 'team_name' => 'Tunisia']);
        $team12 = factory(Team::class)->create(["group_name" => "C", "position" => 4, 'country' => 'Italy', 'team_name' => 'Panama']);
        $team13 = factory(Team::class)->create(["group_name" => "D", "position" => 2, 'country' => 'Germany', 'team_name' => 'Portugal']);
        $team14 = factory(Team::class)->create(["group_name" => "D", "position" => 1, 'country' => 'Holland', 'team_name' => 'Spain']);
        $team15 = factory(Team::class)->create(["group_name" => "D", "position" => 3, 'country' => 'Finland', 'team_name' => 'Morocco']);
        $team16 = factory(Team::class)->create(["group_name" => "D", "position" => 4, 'country' => 'Russia', 'team_name' => 'Iran']);
        // team 1 - 3 win 0 loss 1
        // team 2 - 2 win 1 loss 2
        // team 3 - 1 win 2 loss 3
        // team 4 - 0 win 3 loss 4$
        $response = $this->withoutExceptionHandling()->getJson('api/matches/round16');
        $response->assertSuccessful();
        $response->assertJsonCount(4);
        $response->assertJson([
            [ 'team_1' => $team1->id, 'team_2' => $team5->id ],
            [ 'team_1' => $team2->id, 'team_2' => $team6->id ],
            [ 'team_1' => $team11->id, 'team_2' => $team14->id ],
            [ 'team_1' => $team10->id, 'team_2' => $team13->id ],//
        ]);
    }

}
