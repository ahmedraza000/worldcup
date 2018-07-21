<?php

namespace Tests\Feature;

use App\Player;
use App\Team;
use App\User;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlayerTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function viewing_player_details()
    {
        Passport::actingAs(factory(User::class)->create());

        $player = factory(Player::class)->create();

        $response = $this->getJson('api/players/' . $player->id);

        $response->assertSuccessful();
    }

    /** @test */
    public function unauthorized_user_cannot_view_player_detials()
    {
        $player = factory(Player::class)->create();

        $response = $this->getJson('api/players/' . $player->id);

        $response->assertStatus(401);
    }

    /** @test */
    public function creating_player()
    {
        Passport::actingAs(factory(User::class)->create());

        $team = factory(Team::class)->create();

        $newPlayer = [
            "team_id" => $team->id,
            "firstname" => "Player 1",
            "lastname" => "Player 1",
            "age" => 20,
            "position" => "position",
        ];

        $response = $this->postJson('api/players', $newPlayer);

        $response->assertStatus(201);
    }

    /** @test */
    public function unauthorized_user_cannot_create_player()
    {
        $team = factory(Team::class)->create();

        $newPlayer = [
            "team_id" => $team->id,
            "firstname" => "Player 1",
            "lastname" => "Player 1",
            "age" => 20,
            "position" => "position",
        ];

        $response = $this->postJson('api/players', $newPlayer);

        $response->assertStatus(401);
    }

}
