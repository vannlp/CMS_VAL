<?php
namespace App\Repositories;

use App\Models\StoryChapter;
use App\Models\StoryPost;

class StoryPostRepository extends Repository {
    /**
     * Specify Model class name
     */
    public function model(): string
    {
        return StoryPost::class;
    }
    
    public function create(array $data)
    {
        $model = $this->getModel();
        $authorIdNull = -1;
        
        if(empty($data['status'])) {
            $data['status'] = 0;
        } else {
            $data['status'] = 1;
        }
        
        if(empty($data['type'])) {
            $data['type'] = [
                'new'
            ];
        }
        
        if(empty($data['author_id']) || $data['author_id'] == $authorIdNull) {
            $data['author_id'] = null;
        }

        $story = parent::create($data);

        return $story;
    }
    
    public function update(array $data, $id)
    {
        $authorIdNull = -1;
        
        if(empty($data['status'])) {
            $data['status'] = 0;
        } else {
            $data['status'] = 1;
        }

        $story = parent::update($data, $id);

        return $story;
    }
    
    public function getStoryPostByView() {
        return $this->model->withCount('views')->where('status', 1)->orderBy('views_count', 'asc');
    }
    
    public function getNewStory() {
        return $this->model->with(['newChapter:id,title,slug,story_chapter.story_id,chapter_num'])
            ->addSelect([
                'latest_chapter_date' => StoryChapter::select('created_at')
                    ->whereColumn('story_post.id', 'story_chapter.story_id')
                    ->latest('created_at')
                    ->limit(1),
            ])
            ->whereHas('newChapter', function($q) {
                $q->where('status', 1);
            })
            ->where('status', 1)
            ->orderBy('latest_chapter_date', 'desc');
    }
    
    public function getSearchStory(string $searchValue) {
        return $this->getNewStory()->where('title', 'like', "%{$searchValue}%");
    }
    
    
    public function getStoryByType($type = []) {
        $typeString = json_encode($type);
        return $this->model->with(['newChapter:id,title,slug,story_chapter.story_id,chapter_num'])
            ->withCount(['views', 'chaptersActive'])
            ->where('status', 1)
            ->whereRaw("JSON_CONTAINS(type, '{$typeString}')")
            ->orderBy('views_count', 'asc');
    }
    
    public function getStoryByCategory($category_id) {
        if(!$category_id) {
            return $this->getStoryPostByView()->with(['newChapter:id,title,slug,story_chapter.story_id,chapter_num'])
            ->whereHas('newChapter', function($q) {
                $q->where('status', 1);
            });
                
        }
        
        return $this->getStoryPostByView()
            ->with(['newChapter:id,title,slug,story_chapter.story_id,chapter_num'])
            ->whereHas('newChapter', function($q) {
                $q->where('status', 1);
            })
            ->whereJsonContains('list_category', $category_id);
    }
}
