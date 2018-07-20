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

        $response = $this->withExceptionHandling()->getJson('api/teams');

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

        $response = $this->withExceptionHandling()->getJson('api/teams');

        $response->assertStatus(401);
    }

    /** @test */
    public function can_retrieve_team_details()
    {
        Passport::actingAs(factory(User::class)->create());

        $team = factory(Team::class)->create();

        $response = $this->withExceptionHandling()->getJson('api/teams/' . $team->id);

        $response->assertSuccessful();
        $response->assertExactJson($team->toArray());
    }

    /** @test */
    public function require_authenticated_user_in_retrieving_team_details()
    {
        $team = factory(Team::class)->create();

        $response = $this->withExceptionHandling()->getJson('api/teams/' . $team->id);

        $response->assertStatus(401);
    }
    
}