<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SongLocation extends Model{
    //
    protected $fillable = [
        'user_id', 'title', 'path','lat','lng'
    ];
}
