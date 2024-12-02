<?php

namespace App\Http\Controllers\Story;

use App\DataTables\StoryChapterDataTable;
use App\DataTables\StoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\StoryPost;
use App\Repositories\FileRepository;
use App\Repositories\StoryCategoryRepository;
use App\Repositories\StoryChapterRepository;
use App\Repositories\StoryPostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoryController extends Controller
{
    public function __construct(
        protected StoryCategoryRepository $storyCategoryRepository,
        protected StoryPostRepository $storyPostRepository,
        protected FileRepository $fileRepository,
        protected StoryChapterRepository $storyChapterRepository
    ){ }
    
    public function index()
    {
        return view('pages.story.indexStory');
    }
    
    public function datatable() {
        return (new StoryDataTable())->build();
    }
    
    public function create(Request $request) {
        $categoies = $this->storyCategoryRepository->where('type', 'category')->where('status', 1)->get();
        $authors = $this->storyCategoryRepository->where('type', 'author')->where('status', 1)->get();
        
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
            'avatar'  => ['nullable', 'string']
        ]);
        
        $input = $request->all();
        
        if(!empty($input['slug'])) {
            $input['slug'] = Str::slug($input['slug']);
        }
        
        try {
            DB::beginTransaction();
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
    
    public function edit(Request $request, $id) {
        $story = $this->storyPostRepository->find($id);
        $categoies = $this->storyCategoryRepository->where('type', 'category')->where('status', 1)->get();
        $authors = $this->storyCategoryRepository->where('type', 'author')->where('status', 1)->get();
        
        $listType = StoryPost::TYPE;
        
        return view('pages.story.editStory', [
            'story' => $story,
            'categories' => $categoies,
            'authors' => $authors,
            'listType' => $listType
        ]);
    }
    
    public function update(Request $request, $id){
        $request->validate([
            'title' => ['required', 'string', Rule::unique('story_post')->ignore($id)],
            'description' => ['nullable', 'string'],
            'slug' => ['required', 'string', Rule::unique('story_post')->ignore($id)],
            'list_category' => ['array'],
            'author_id' => ['nullable'],   
            'avatar'  => ['nullable', 'string']
        ]);
        
        $story = $this->storyPostRepository->find($id);
        
        $input = $request->all();
        
        if(!empty($input['slug'])) {
            $input['slug'] = Str::slug($input['slug']);
        }
        
        try {
            DB::beginTransaction();
            $story = $this->storyPostRepository->update($input, $id);
            
            DB::commit();
            return redirect()->back()->with('message', __('app.base.update_data_success'));
        } catch (\Throwable $th) {
            //throw $th;
            Log::error("StoryController::store", [
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'message' => $th
            ]);
            DB::rollBack();
            return redirect()->back()->with('error_message', __('app.base.update_data_error'));
        }
    }  
      
    public function storyChapterDatatable() {
        return (new StoryChapterDataTable())->build();
    }
    
    public function createChapter(Request $request) {
        $storyId = $request->get('story_id' ,null);
        
        if(!$storyId) {
            return abort(400, "Missing story_id parameter");
        }
        
        $story = $this->storyPostRepository->find($storyId);
        
        return view('pages.story.createChapter', [
            'story' => $story
        ]);
    }
    
    public function storeChapter(Request $request) {
        $request->validate([
            'title' => ['required', 'string', 'unique:story_chapter'],
            'description' => ['nullable', 'string'],
            'meta_description' => ['nullable', 'string'],
            'slug' => ['required', 'string'], 
            'story_id' => ['required']
        ]);
        
        $input = $request->all();
        
        if(!empty($input['slug'])) {
            $input['slug'] = Str::slug($input['slug']);
        }
        
        try {
            DB::beginTransaction();
            $storyChapter = $this->storyChapterRepository->create($input);
            
            DB::commit();
            return redirect()->back()->with('message', __('app.base.create_data_success'));
        } catch (\Throwable $th) {
            //throw $th;
            Log::error("StoryController::storeChapter", [
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'message' => $th
            ]);
            DB::rollBack();
            return redirect()->back()->with('error_message', __('app.base.create_data_error'));
        }
    }
    
    public function editChapter(Request $request, $chapter_id) {
        $storyId = $request->get('story_id' ,null);
        $chapterId = $chapter_id;
        
        $chapter = $this->storyChapterRepository->find($chapterId);
        
        if(!$storyId) {
            $storyId =  $chapter->story_id;
        }
        
        $story = $this->storyPostRepository->find($storyId);
        
        return view('pages.story.editChapter', [
            'story' => $story,
            'chapter' => $chapter
        ]);
    }
    
    public function updateChapter(Request $request, $id) {
        // dd(Rule::unique('story_chapter')->ignore($id, 'title'));
        $request->validate([
            'title' => ['required', 'string', Rule::unique('story_chapter')->ignore($id)],
            'description' => ['nullable', 'string'],
            'meta_description' => ['nullable', 'string'],
            'slug' => ['required', 'string'], 
            'story_id' => ['required']
        ]);
        
        $input = $request->all();
        
        if(!empty($input['slug'])) {
            $input['slug'] = Str::slug($input['slug']);
        }
        
        try {
            DB::beginTransaction();
            $storyChapter = $this->storyChapterRepository->update($input, $id);
            
            DB::commit();
            return redirect()->back()->with('message', __('app.base.create_data_success'));
        } catch (\Throwable $th) {
            //throw $th;
            Log::error("StoryController::updateChapter", [
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'message' => $th
            ]);
            DB::rollBack();
            return redirect()->back()->with('error_message', __('app.base.create_data_error'));
        }
    }
    
    public function deleteStory(Request $request, $id) { 
        try {
            DB::beginTransaction();
            // delete all chapter
            $this->storyChapterRepository->where('story_id', $id)->delete();
            $this->storyPostRepository->find($id)->delete();
            DB::commit();
            
            return jsonRes()->responseWithMessage(__('app.base.delete_data_success'), 200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            Log::error("StoryCategoryController::deleteChapter", [
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'message' => $th->getMessage()
            ]);
            return jsonRes()->responseWithMessage(__('app.base.delete_data_error'), 500);
        }
    }
    
    public function deleteChapter(Request $request, $id) { 
        try {
            DB::beginTransaction();
            $this->storyChapterRepository->find($id)->delete();
            DB::commit();
            
            return jsonRes()->responseWithMessage(__('app.base.delete_data_success'), 200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            Log::error("StoryCategoryController::deleteChapter", [
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'message' => $th->getMessage()
            ]);
            return jsonRes()->responseWithMessage(__('app.base.delete_data_error'), 500);
        }
    }
}
