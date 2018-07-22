<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    const GROUPS = [
        "A", "B", "C", "D", "E", "F", "G", "H"
    ];
    
    protected $fillable = [
        "team_name",
        "country",
        "group_name",
        "position",
    ];

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function isMatched($stage)
    {
        return Match::where("stage", $stage)
                ->where("team_1", $this->id)
                ->orWhere("team_2", $this->id)
                ->get()->isNotEmpty();
    }
    
}
