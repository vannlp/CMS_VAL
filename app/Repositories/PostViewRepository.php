<?php

namespace App\Repositories;

use App\Models\PostView;

class PostViewRepository extends Repository {
    /**
     * Specify Model class name
     */
    public function model(): string
    {
        return PostView::class;
    }
    
    public function create(array $data)
    {
        $model = $this->getModel();
        
        if(empty($data['user_id'])) {
            $data['user_id'] = null;
        }
        
        if(empty($data['ip'])) {
            $data['ip'] = request()->getClientIp();
        }

        $postView = parent::create($data);

        return $postView;
    }
}