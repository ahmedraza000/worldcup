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
    
}
