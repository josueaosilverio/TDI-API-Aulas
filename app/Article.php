<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;
    protected $fillable = ['title', 'description', 'image', 'user_id'];

    function author()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
