<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Laravel\Passport\Passport;
use App\Team;

class TeamTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function can_list_teams()
    {
        Passport::actingAs(factory(User::class)->create());

        $team1 = factory(Team::class)->create();
        $team2 = factory(Team::class)->create();
        $team3 = factory(Team::class)->create();
        $team4 = factory(Team::class)->create();
        $team5 = factory(Team::class)->create();

        $response = $this->getJson('api/teams');

        $response->assertSuccessful();
        $this->assertCount(5, $response->json('data'));
        $response->assertJson(['data' => [
            $team1->toArray(),
            $team2->toArray(),
            $team3->toArray(),
            $team4->toArray(),
            $team5->toArray(),
        ]]);
    }

    /** @test */
    public function require_authenticated_user_in_retrieving_team_list()
    {
        factory(Team::class, 5)->create();

        $response = $this->getJson('api/teams');

        $response->assertStatus(401);
    }

    /** @test */
    public function can_retrieve_team_details()
    {
        Passport::actingAs(factory(User::class)->create());

        $team = factory(Team::class)->create();

        $response = $this->getJson('api/teams/' . $team->id);

        $response->assertSuccessful();
        $response->assertExactJson($team->toArray());
    }

    /** @test */
    public function require_authenticated_user_in_retrieving_team_details()
    {
        $team = factory(Team::class)->create();

        $response = $this->getJson('api/teams/' . $team->id);

        $response->assertStatus(401);
    }

    /** @test */
    public function creating_team()
    {
        Passport::actingAs(factory(User::class)->create());

        $team = [
            "team_name" => "Team 1",
            "country" => "Russia",
            "group_name" => "Group A",
        ];

        $response = $this->withoutExceptionHandling()->postJson('api/teams', $team);

        $response->assertStatus(201);
    }

    /** @test */
    public function require_authenticated_user_for_creating_team()
    {
        $team = [
            "team_name" => "Team 1",
            "country" => "Russia",
        ];

        $response = $this->postJson('api/teams', $team);

        $response->assertStatus(401);
    }
    
    /** @test */
    public function validate_team_details_before_storing_to_db()
    {
        Passport::actingAs(factory(User::class)->create());

        $team = [
            "team_name" => "",
            "country" => "",
            "group_name" => "",
        ];

        $response = $this->postJson('api/teams', $team);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors("team_name");
        $response->assertJsonValidationErrors("country");
        $response->assertJsonValidationErrors("group_name");
    }

    /** @test */
    public function updating_team_details()
    {
        Passport::actingAs(factory(User::class)->create());

        $team = factory(Team::class)->create();

        $newTeamDetails = [
            "team_name" => "New Team",
            "country" => "New Country",
            "group_name" => "Group B",
        ];

        $response = $this->putJson('api/teams/' . $team->id, $newTeamDetails);

        $response->assertStatus(204);
        $this->assertEquals("New Team", $team->fresh()->team_name);
        $this->assertEquals("New Country", $team->fresh()->country);
        $this->assertEquals("Group B", $team->fresh()->group_name);
    }

    /** @test */
    public function require_authenticated_user_for_updating_team()
    {
        $team = factory(Team::class)->create();

        $newTeamDetails = [
            "name" => "New Team",
            "country" => "New Country",
            "group_name" => "Group A"
        ];

        $response = $this->putJson('api/teams/' . $team->id, $newTeamDetails);

        $response->assertStatus(401);
    }
    
    /** @test */
    public function validate_team_details_before_updating()
    {
        Passport::actingAs(factory(User::class)->create());

        $team = factory(Team::class)->create();

        $newTeamDetails = [
            "team_name" => "",
            "country" => "",
            "group_name" => "",
        ];

        $response = $this->putJson('api/teams/' . $team->id, $newTeamDetails);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors("team_name");
        $response->assertJsonValidationErrors("country");
        $response->assertJsonValidationErrors("group_name");
    }
    
}
