<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    protected $table = 'episode';
    protected $fillable = [
        "id",
        "name",
        "air_date",
        "episode",
        "characters",
        "url",
        "created"
    ];
}
