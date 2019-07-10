<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'meta'
    ];

    protected $casts = [
      'meta' => 'array'
    ];

    protected $hidden = [
        'pivot',
        'user_id',
        'updated_at'
    ];
}
