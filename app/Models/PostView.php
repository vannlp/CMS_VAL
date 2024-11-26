<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostView extends Model
{
    use HasFactory;
    
    protected $table = "post_views";
    
    const TABLE = [
        'story_category',
        'story_chapter',
        'story_post'
    ];

    protected $fillable = [
        'id',
        'table',
        'ip',
        'post_id',
        'user_id',
        'created_at',
        'updated_at',
    ];
}