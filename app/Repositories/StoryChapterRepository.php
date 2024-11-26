<?php
namespace App\Repositories;

use App\Models\StoryChapter;

class StoryChapterRepository extends Repository {
    /**
     * Specify Model class name
     */
    public function model(): string
    {
        return StoryChapter::class;
    }
    
    public function create(array $data)
    {
        $model = $this->getModel();
        $storyIdNull = -1;
        
        if(empty($data['status'])) {
            $data['status'] = 0;
        } else {
            $data['status'] = 1;
        }
        
        if(empty($data['story_id']) || $data['story_id'] == $storyIdNull) {
            $data['story_id'] = null;
        }

        $storyChapter = parent::create($data);

        return $storyChapter;
    }
    
    public function update(array $data, $id)
    {
        if(empty($data['status'])) {
            $data['status'] = 0;
        } else {
            $data['status'] = 1;
        }

        $story = parent::update($data, $id);

        return $story;
    }
}