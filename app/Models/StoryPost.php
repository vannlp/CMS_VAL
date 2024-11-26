<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryPost extends Model
{
    use HasFactory;
    
    protected $table = "story_post";

    protected $fillable = [
        'id',
        'title',
        'description',
        'slug',
        'list_category',
        'author_id',
        'status',
        'avatar',
        'meta_description',
        'created_at',
        'updated_at',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'list_category' => 'array',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function acthor()
    {
        return $this->belongsTo(StoryCategory::class, 'author_id', 'id');
    }
    
    public function image()
    {
        return $this->belongsTo(File::class, 'image_id', 'id');
    }
    
    public function chapters() {
        return $this->hasMany(StoryChapter::class, 'story_id', 'id');
    }

    public function views() {
        return $this->hasMany(PostView::class, 'post_id', 'id')->where('table', 'story_post');
    }
}