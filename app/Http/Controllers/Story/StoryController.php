<?php

namespace App\Http\Controllers\Story;

use App\DataTables\StoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\StoryPost;
use App\Repositories\FileRepository;
use App\Repositories\StoryCategoryRepository;
use App\Repositories\StoryPostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StoryController extends Controller
{
    public function __construct(
        protected StoryCategoryRepository $storyCategoryRepository,
        protected StoryPostRepository $storyPostRepository,
        protected FileRepository $fileRepository
    ){ }
    
    public function index()
    {
        return view('pages.story.indexStory');
    }
    
    public function datatable() {
        return (new StoryDataTable())->build();
    }
    
    public function create(Request $request) {
        $categoies = $this->storyCategoryRepository->where('type', 'category')->get();
        $authors = $this->storyCategoryRepository->where('type', 'author')->get();
        
        return view('pages.story.createStory', [
            'categories' => $categoies,
            'authors' => $authors,
        ]);
    }
    
    public function store(Request $request) {
        $request->validate([
            'title' => ['required', 'string', 'unique:story_post'],
            'description' => ['nullable', 'string'],
            'slug' => ['required', 'string', 'unique:story_post'],
            'list_category' => ['array'],
            'author_id' => ['nullable'],   
            'avatar'  => ['nullable', 'file', 'mimes:jpg,png,pdf', 'max:2048']
        ]);
        
        $input = $request->all();
        
        $avaterFileImage = $request->file('avatar');
        
        if(!empty($input['slug'])) {
            $input['slug'] = Str::slug($input['slug']);
        }
        
        try {
            DB::beginTransaction();
            // xử lý dữ liệu
            $avatar = $this->fileRepository->createAndUploadFile($avaterFileImage, [
                'alt' => $input['title'],
                'type' => 'story'
            ]);
            
            $input['image_id'] = $avatar->id ?? null;
            $story = $this->storyPostRepository->create($input);
            
            DB::commit();
            return redirect()->back()->with('message', __('app.base.create_data_success'));
        } catch (\Throwable $th) {
            //throw $th;
            Log::error("StoryController::store", [
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'message' => $th
            ]);
            DB::rollBack();
            return redirect()->back()->with('error_message', __('app.base.create_data_error'));
        }
    }
}
