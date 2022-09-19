<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Routes extends Model
{
    use HasFactory;

    protected $fillable = [
        'object_id',
        'canonical',
        'module',
    ];

    protected $table = 'routes';
}
