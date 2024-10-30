<?php
namespace App\Repositories;

use App\Models\User;

class UserRepository extends Repository {
    /**
     * Specify Model class name
     */
    public function model(): string
    {
        return User::class;
    }
    
    
    public function create(array $data)
    {
        $model = $this->getModel();
        
        if(empty($data['role_id'])) {
            $data['role_id'] = 2;
        }
        
        if(empty($data['status'])) {
            $data['status'] = 0;
        } else {
            $data['status'] = 1;
        }

        $user = parent::create($data);

        return $user;
    }
}