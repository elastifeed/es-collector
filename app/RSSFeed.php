<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RSSFeed extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'link',
        'hashedLink'
    ];

    /**
     * Returns all users with this feed
     */
    public function users(){
        return $this->belongsToMany('App\User');
    }
}
