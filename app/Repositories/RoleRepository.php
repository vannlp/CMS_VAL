<?php
namespace App\Repositories;

use App\Models\Role;

class RoleRepository extends Repository {
    /**
     * Specify Model class name
     */
    public function model(): string
    {
        return Role::class;
    }
    
    public function create(array $attributes)
    {
        
        if(empty($attributes['permission_type'])) {
            $attributes['permission_type'] = 'custom';
        }
        
        if(empty($attributes['is_login_admin'])) {
            $attributes['is_login_admin'] = 0;
        }
        
        $role = parent::create($attributes);
        
        return $role;
    }
}