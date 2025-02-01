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
        // $truyenFull = new TruyenFull();
        
        // $truyenFull->scrape(9, 1531, "https://truyenfull.io/linh-vu-thien-ha/chuong-1532/", 1535);
        
        // die;
        
        $categories = $this->storyCategoryRepository->getCategories()->get();
        $categoryOption = $this->storyCategoryRepository->getCategoryHomeOption()->take(6)->get();
        $topStoryPostViews = $this->storyPostRepository->getStoryPostByView()->take(12)->get();
        $newStorys = $this->storyPostRepository->getNewStory()->take(16)->get();
        $fullStorys = $this->storyPostRepository->getStoryByType(['full'])->take(16)->get();
        // get categories
        $categoryIds = $newStorys->pluck('list_category')->flatten()->unique();
        // Lấy thông tin chi tiết các danh mục
        $categories2 = $this->storyCategoryRepository->select(['id', 'name', 'slug'])->whereIn('id', $categoryIds)->get()->keyBy('id');

        // Gán danh mục vào từng bài viết
        $newStorys->map(function ($story) use ($categories2) {
            $story->categories = collect($story->list_category)->map(function ($id) use ($categories2) {
                return $categories2->get($id);
            });
            return $story;
        });
        
        return view('FE.pages.home', [
            'categories' => $categories,
            'categoryOption' => $categoryOption,
            'topStoryPostViews' => $topStoryPostViews,
            'newStorys' => $newStorys,
            'fullStorys' => $fullStorys,
        ]);
    }
    
    public function getStoryHtml(Request $request, $category_id) {
        $getStoryByCategory = $this->storyPostRepository->getStoryByCategory($category_id)->take(12)->get();
        
        return response()->view('FE.partials.hotStoryItem', ['getStoryByCategory' => $getStoryByCategory], 200)
                     ->header('Content-Type', 'text/html');
    }
}