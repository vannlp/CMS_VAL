<?php
namespace App\Repositories;

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
}
