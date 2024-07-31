<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeP extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'proyect_id',
    ];
}
