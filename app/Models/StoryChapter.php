<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryChapter extends Model
{
    use HasFactory;

    protected $table = "story_chapter";

    protected $fillable = [
        'id',
        'title',
        'story_id',
        'meta_description',
        'description',
        'slug',
        'status',
        'created_at',
        'updated_at',
    ];
    
    public function storyPost()
    {
        return $this->belongsTo(StoryPost::class, 'story_id', 'id');
    }
}