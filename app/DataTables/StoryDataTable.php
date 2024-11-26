<?php

namespace App\DataTables;

use App\Models\StoryPost;
use Illuminate\Support\HtmlString;
use Yajra\DataTables\Facades\DataTables;

class StoryDataTable extends BaseDataTable {
    /**
     * @var array $columns The columns that should be displayed in the data table.
     */
    protected $columns = [
        'id',
        'title',
        'slug',
        'list_category',
        'author_id',
        'status',
        'created_at',
        'updated_at',
        'avatar',
        'author',
        'story_info',
        'chapters_count'
    ];
    
    /**
     * @var array $columns The raw columns that should be displayed in the data table.
     */
    protected $rawColumns = [
        'story_info',
    ];
    
    /**
     * Get the query object for the data table.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function modelQuery(){
        return StoryPost::query()->with(['acthor'])->withCount(['chapters' => function ($query)  {
            $query->where('status', '1');
        }]);
    }
    
    /**
     * Apply the search filter to the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return void
     */
    public function query($query) {
        
        // Check for filter:search
        if ($search = request()->input('search.value')) {
            $field = 'name';
            $listField = [
                'name',
                'slug',
            ];

            $query->where(function ($q) use ($listField, $field, $search) {
                $field = trim($field);
                $operator = 'like';
                foreach($listField as $field) {
                    $q->orWhere($field, $operator, '%' . trim($search) . '%');
                }
            });
        }
    }
    
    /**
     * Edit the columns of the data table.
     *
     * @param \Yajra\DataTables\DataTables $dataTable
     * @return void
     */
    public function editColumn($dataTable) {
        
        $dataTable->addColumn('chapters_count', function($item) {
            return $item->chapters_count ?? 0;
        });
        
        $dataTable->addColumn('story_info', function($item) {
            $avatar_url = $item->avatar ?? '';
            $html = "
            <div class='d-flex justify-content-start align-items-center'>
                <div class='avatar-wrapper me-3'>
                    <div class='avatar rounded-3 bg-label-secondary' >
                        <img src='{$avatar_url}' class='rounded-2' />
                    </div>
                </div>
                
                <div class='d-flex flex-column'>
                    <span class='text-nowrap text-heading fw-medium'>{$item->title}</span>
                </div>
            </div>";
            return $html;
        });
        
        $dataTable->addColumn('author', function($item) {
            $acthor = $item->acthor;
            return $acthor->name ?? "";
        });
    }
}