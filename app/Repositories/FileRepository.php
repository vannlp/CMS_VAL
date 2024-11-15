<?php

namespace App\Repositories;

use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FileRepository extends Repository {
    /**
     * Specify Model class name
     */
    public function model(): string
    {
        return File::class;
    }
    
    
    public function createAndUploadFile($file, array $data) {
        if(empty($data['alt'])) {
            $data['alt'] = '';
        }
        
        // upload file
        $path = Storage::putFile('public/image', $file);
        $data['url'] = $path;
        
        $file = parent::create($data);
        return $file;
    }
}