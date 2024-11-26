<?php
namespace App\DataTables;

use App\Models\StoryChapter;
use Yajra\DataTables\Facades\DataTables;

class StoryChapterDataTable extends BaseDataTable {
    /**
     * @var array $columns The columns that should be displayed in the data table.
     */
    protected $columns = [
        'id',
        'title',
        'story_id',
        'meta_description',
        // 'description',
        'slug',
        'status',
        'created_at',
        'updated_at',
    ];
    
    /**
     * Get the query object for the data table.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function modelQuery(){
        return StoryChapter::query();
    }
    
    /**
     * Apply the search filter to the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return void
     */
    public function query($query) {
        $orderBy = request('order', []);
        $story_id = request()->get('story_id');
        
        if($story_id) {
            $query->where('story_id', $story_id);
        }
        
        // Check for filter:search
        if ($search = request()->input('search.value')) {
            $field = 'title';
            $listField = [
                'title',
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
     * Apply the filter after create datatable.
     *
     * @param \Yajra\DataTables\EloquentDataTable $dataTable
     * @return void
     */
    public function queryAfter($dataTable) {
        // order by
        $dataTable->orderColumn('id', function ($query, $order) {
            $query->orderBy('id', $order);
        });
        
        $dataTable->orderColumn('title', function ($query, $order) {
            $query->orderBy('title', $order);
        });
        
        $dataTable->orderColumn('slug', function ($query, $order) {
            $query->orderBy('slug', $order);
        });
        
        $dataTable->orderColumn('created_at', function ($query, $order) {
            $query->orderBy('created_at', $order);
        });
        
        // dd($dataTable->toSql());
    }
    
    /**
     * Edit the columns of the data table.
     *
     * @param \Yajra\DataTables\DataTables $dataTable
     * @return void
     */
    public function editColumn($dataTable) {
        $dataTable->addColumn('created_at', function($item) {
            return $item->created_at->format('d/m/Y H:i:s');
        });
    }
}