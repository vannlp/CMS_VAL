<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryPost extends Model
{
    use HasFactory;
    
    const TYPE = [
        'new' => ['name' => "New", 'class' => 'story-item__badge story-item__badge-new badge text-bg-info text-light'],
        'full' => ['name' => "Full", 'class' => 'story-item__badge badge text-bg-success'],
        'hot' => ['name' => "Hot", 'class' => 'story-item__badge story-item__badge-hot badge text-bg-danger'],
    ];
    
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
        'type',
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
        'type' => 'array'
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
    
    public function chaptersActive() {
        return $this->hasMany(StoryChapter::class, 'story_id', 'id')->where('status', 1);
    }
    
    public function chaptersActiveOrderByChapterNum() {
        return $this->hasMany(StoryChapter::class, 'story_id', 'id')->where('status', 1)->orderBy('chapter_num', 'asc');
    }

    public function views() {
        return $this->hasMany(PostView::class, 'post_id', 'id')->where('table', 'story_post');
    }
    
    
    public function newChapter()
    {
        return $this->hasOne(StoryChapter::class, 'story_id', 'id')->latestOfMany();
    }
    
    public function categories()
    {
        return StoryCategory::whereIn('id', $this->list_category)->get();
    }
}