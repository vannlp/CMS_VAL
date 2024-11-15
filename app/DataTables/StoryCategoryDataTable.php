<?php
namespace App\DataTables;

use App\Models\StoryCategory;
use Yajra\DataTables\Facades\DataTables;

class StoryCategoryDataTable extends BaseDataTable {
    /**
     * @var array $columns The columns that should be displayed in the data table.
     */
    protected $columns = [
        "id",
        'name',
        'short_description',
        'description',
        'parent_id',
        'parent',
        'status',
        'slug',
        'type',
        'created_at',
        'updated_at',
    ];
    
    /**
     * Get the query object for the data table.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function modelQuery(){
        return StoryCategory::query();
    }
    
    /**
     * Apply the search filter to the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return void
     */
    public function query($query) {
        $type_filter = request('type_filter');
        
        if($type_filter) {
            $query->where('type', $type_filter);
        }
        
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
    }
}