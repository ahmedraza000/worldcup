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

    public function testListTeams()
    {
        Passport::actingAs(factory(User::class)->create());

        $team1 = factory(Team::class)->create();
        $team2 = factory(Team::class)->create();
        $team3 = factory(Team::class)->create();
        $team4 = factory(Team::class)->create();
        $team5 = factory(Team::class)->create();

        $response = $this->withExceptionHandling()->getJson(route('api.teams.index'));

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
    
}
