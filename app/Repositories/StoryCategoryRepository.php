<?php
namespace App\Repositories;

use App\Models\StoryCategory;
use Illuminate\Support\Str;

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
    
    public function createAuthorByName(string $name) {
        $model = $this->getModel();
        
        $data['parent_id'] = null;
        
        $data['status'] = 1;
        
        $data['short_description'] = $name;
        $data['name'] = $name;
        $data['slug'] = Str::slug($name);
        $data['type'] = 'author';
        $data['description'] = "";

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
    
    public function getCategories() {
        return $this->model->where('status', 1)->where('type', 'category');
    }
    
    public function getAuthors() {
        return $this->model->where('status', 1)->where('type', 'author');
    }
    
    public function getCategoryHomeOption() {
        return $this->model->select(['id', 'name'])->where('status', 1)->where('type', 'category');
    }
}