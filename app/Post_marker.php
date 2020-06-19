<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post_marker extends Model
{
    protected $table = "post_markers";
    
    protected $fillable = [
        'authtoken',
        'marker',
        'linkpatt',
        'name',
        'tags',
        'description',
        'experienceid'
    ];
}
