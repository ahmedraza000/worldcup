<?php

namespace App\Http\Controllers\Api;

use App\Match;
use App\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matches = Match::all();
        return $matches;
    }

    public function round16()
    {
        $matches = Match::where("stage", "round16")->get();
        if($matches->isNotEmpty()) return $matches;
        // Get Group matches winners
        // Need to get 1st and 2nd top teams per group
        $qualifiedTeams = Team::whereIn("position", [1,2])
            ->orderBy('group_name')
            ->orderBy('position')
            ->get();
        // Matching Teams
        foreach($qualifiedTeams as $team) {
            $team1 = $team;
            // Check if team already matched
            if($team1->isMatched("round16")) continue;
            // If not Matched
            // Determine 2nd team
            $team1Group = array_search($team1->group_name, Team::GROUPS);
            $match_group = Team::GROUPS[$team1Group + 1];
            $team2 = $qualifiedTeams->where('group_name', $match_group)->first();
            if($team2->isMatched("round16")) $team2 = $qualifiedTeams->where('group_name', $match_group)->last();
            // Create Match
            $match = Match::create([
                "team_1" => $team1->id,
                "team_2" => $team2->id,
                "stage" => 'round16',
            ]);
        }
        $matches = Match::where("stage", "round16")->get();
        return $matches;
    }

}
