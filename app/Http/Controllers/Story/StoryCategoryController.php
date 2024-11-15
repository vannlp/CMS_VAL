<?php

namespace App\Http\Controllers\Story;

use App\DataTables\StoryCategoryDataTable;
use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Models\StoryCategory;
use App\Repositories\StoryCategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StoryCategoryController extends Controller
{

    public function __construct(protected StoryCategoryRepository $storyCategoryRepository){ }

    public function index()
    {
        $parentCategorys = $this->storyCategoryRepository->whereNull('parent_id')->get(); 
        return view('pages.story.indexCategory', [
            'parentCategorys' => $parentCategorys,
            'type' => StoryCategory::TYPE
        ]);
    }

    public function createStoryCategory(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'unique:roles'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'parent_id' => ['nullable'],
            'slug' => ['required', 'string'],
            'type' => ['required', "in:" . implode(',', StoryCategory::TYPE)]
        ]);
        
        $input = $request->all();
        
        if(!empty($input['slug'])) {
            $input['slug'] = Str::slug($input['slug']);
        }
          
        try {
            DB::beginTransaction();
            $storyCategory = $this->storyCategoryRepository->create($input);
            DB::commit();
            return redirect()->back()->with('message', __('app.base.create_data_success'));
        } catch (\Throwable $th) {
            //throw $th;
            Log::error("StoryCategoryController::createStoryCategory", [
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'message' => $th->getMessage()
            ]);
            DB::rollBack();
            return redirect()->back()->with('error_message', __('app.base.create_data_error'));
        }
    }

    public function getOne($id)
    {
        $storyCategory = $this->storyCategoryRepository->find($id);
        return jsonRes()->responseWithData(__('app.base.get_data_success'), $storyCategory, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'parent_id' => ['nullable'],
            'slug' => ['required', 'string'],
            'type' => ['required', "in:" . implode(',', StoryCategory::TYPE)]
        ]);
        
        $data = $request->all();
        
        if(!empty($data['slug'])) {
            $data['slug'] = Str::slug($data['slug']);
        }
        
        try {
            DB::beginTransaction();
            $storyCategory = $this->storyCategoryRepository->update($data, $id);
            DB::commit();
            return redirect()->back()->with('message', __('app.base.update_data_success'));
        } catch (\Throwable $th) {
            //throw $th;
            Log::error("StoryCategoryController::update", [
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'message' => $th->getMessage()
            ]);
            DB::rollBack();
            return redirect()->back()->with('error_message', __('app.base.update_data_error'));
        }
    }

    public function delete($id) {
        try {
            DB::beginTransaction();
            $this->storyCategoryRepository->find($id)->delete();
            DB::commit();
            
            return jsonRes()->responseWithMessage(__('app.base.delete_data_success'), 200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            Log::error("StoryCategoryController::delete", [
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'message' => $th->getMessage()
            ]);
            return jsonRes()->responseWithMessage(__('app.base.delete_data_error'), 500);
        }
        
    }

    public function datatable() {
        return (new StoryCategoryDataTable())->build();
    }
}