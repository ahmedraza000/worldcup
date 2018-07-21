<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{

    protected  $fillable = [
        "team_id",
        "firstname",
        "lastname",
        "age",
        "position",
    ];

}
