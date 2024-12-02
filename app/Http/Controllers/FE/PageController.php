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
use Illuminate\Pagination\Paginator;

class PageController extends Controller
{
    public function __construct(
        protected StoryCategoryRepository $storyCategoryRepository,
        protected StoryPostRepository $storyPostRepository,
        protected StoryChapterRepository $storyChapterRepository,
    ) {}
        
    public function detail(Request $request, $slug) {
        Paginator::useBootstrap(); // Kích hoạt Bootstrap cho phân trang
        if(!$slug) {
            return abort(400);
        }
        
        $story = $this->storyPostRepository
            ->with(['acthor:id,name,slug'])
            ->where('slug', $slug)->first();
        
        $categories = $this->storyCategoryRepository->getCategories()->get();
            
            
        if(!$story) {
            return abort(404);
        }
        $chapters = $this->storyChapterRepository
            ->select(['id', 'title', 'slug'])
            ->where('story_id', $story->id)
            ->orderBy('chapter_num', 'asc')
            ->paginate(50);
        
        return view('FE.pages.detail', [
            'story' => $story,
            'chapters' => $chapters,
            'categories' => $categories
        ]);
    }
    
    public function categoryPage(Request $request, $slug) {
        $category = $this->storyCategoryRepository->where('slug', $slug)->first();
        $getStoryByCategory = $this->storyPostRepository->getStoryByCategory("$category->id")->take(12)->get();
        return view('FE.pages.categoryPage', [
            'category' => $category,
            'getStoryByCategory' => $getStoryByCategory,
        ]);
    }
    
    public function detailChapter(Request $request, $slugStory, $slugChapter) {
        $story = $this->storyPostRepository
            ->with(['chaptersActiveOrderByChapterNum:id,title,slug,chapter_num,story_id'])
            ->select(['id', 'slug', 'title'])
            ->where('slug', $slugStory)->first();
        if(!$story) {
            return abort(404);
        }
        $chapter = $this->storyChapterRepository->where('slug', $slugChapter)->where('story_id', $story->id)->first();

        if(!$chapter) {
            return abort(404);
        }
        
        if(!$story) {
            return abort(404);
        }
        
        $nextChapNum = $chapter->chapter_num + 1;
        $prevChapNum = $chapter->chapter_num - 1;
        
        $nextChapter = $this->storyChapterRepository
            ->select(['id', 'title', 'slug'])
            ->where('story_id', $story->id)->where('chapter_num', $nextChapNum)->first();  

        $prevChapter = $this->storyChapterRepository
            ->select(['id', 'title', 'slug'])
            ->where('story_id', $story->id)->where('chapter_num', $prevChapNum)->first();
            
        return view('FE.pages.chapter', [
            'chapter' => $chapter,
            'story' => $story,
            'nextChapter' => $nextChapter,
            'prevChapter' => $prevChapter
        ]);
    }
    
}