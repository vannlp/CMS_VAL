<?php
namespace App\Repositories;

use App\Models\StoryCategory;

class StoryCategoryRepository extends Repository {
    /**
     * Specify Model class name
     */
    public function model(): string
    {
        return StoryCategory::class;
    }
    
    public function create(array $data)
    {
        $dataDanhMucCha = -1;
        $model = $this->getModel();
        
        if(empty($data['parent_id']) || $data['parent_id'] == $dataDanhMucCha) {
            $data['parent_id'] = null;
        }
        
        if(empty($data['status'])) {
            $data['status'] = 0;
        } else {
            $data['status'] = 1;
        }

        $storyCategory = parent::create($data);

        return $storyCategory;
    }
    
    public function update(array $data, $id)
    {
        $dataDanhMucCha = -1;
        
        if(empty($data['parent_id']) || $data['parent_id'] == $dataDanhMucCha) {
            $data['parent_id'] = null;
        }
        
        if(empty($data['status'])) {
            $data['status'] = 0;
        } else {
            $data['status'] = 1;
        }

        $storyCategory = parent::update($data, $id);

        return $storyCategory;
    }
}