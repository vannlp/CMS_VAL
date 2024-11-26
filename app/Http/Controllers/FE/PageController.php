<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\Controller;
use App\Models\StoryCategory;
use App\Models\StoryChapter;
use App\Models\StoryPost;
use App\Repositories\StoryCategoryRepository;
use App\Repositories\StoryChapterRepository;
use App\Repositories\StoryPostRepository;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct(
        protected StoryCategoryRepository $storyCategoryRepository,
        protected StoryPostRepository $storyPostRepository,
        protected StoryChapterRepository $storyChapterRepository,
    ) {}
        
    
    
}