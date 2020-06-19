<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostPattern extends Model
{
    protected $table = "post_patterns";
    
    protected $fillable = [
        'authtoken',
        'patt',
        'name',
        'tags',
        'description',
        'experienceid'
    ];
}
