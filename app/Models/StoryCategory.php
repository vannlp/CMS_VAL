<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryCategory extends Model
{
    use HasFactory;
    
    protected $table = "story_category";
    
    const TYPE = [
        'author',
        'category'
    ];

    protected $fillable = [
        'id',
        'name',
        'short_description',
        'description',
        'parent_id',
        'status',
        'slug',
        'type',
        'created_at',
        'updated_at',
    ];
    
    public function parent() {
        return $this->belongsTo(StoryCategory::class, 'parent_id', 'id');
    }

}