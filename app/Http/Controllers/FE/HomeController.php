<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Setting;
use App\Repositories\StoryCategoryRepository;
use App\Repositories\StoryChapterRepository;
use App\Repositories\StoryPostRepository;
use App\Scraper\TruyenFull;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected StoryCategoryRepository $storyCategoryRepository,
        protected StoryPostRepository $storyPostRepository,
        protected StoryChapterRepository $storyChapterRepository,
    ) {}
    
    public function index() {
        $categories = $this->storyCategoryRepository->getCategories()->get();
        $categoryOption = $this->storyCategoryRepository->getCategoryHomeOption()->take(6)->get();
        $topStoryPostViews = $this->storyPostRepository->getStoryPostByView()->take(12)->get();
        
        return view('FE.pages.home', [
            'categories' => $categories,
            'categoryOption' => $categoryOption,
            'topStoryPostViews' => $topStoryPostViews
        ]);
    }
}