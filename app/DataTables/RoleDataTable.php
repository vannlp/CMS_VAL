<?php
namespace App\DataTables;

use App\Models\Role;

class RoleDataTable extends BaseDataTable {
    /**
     * @var array $columns The columns that should be displayed in the data table.
     */
    protected $columns = [
        "id",
        "name",
        "description"
    ];
    
    /**
     * Get the query object for the data table.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function modelQuery(){
        return Role::query();
    }
    
    /**
     * Apply the search filter to the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return void
     */
    public function query($query) {
        $query->where('name', '!=','Super Admin');
        
        // Check for filter:search
        if ($search = request()->input('search.value')) {
            $field = 'name';
            $listField = [
                'name'
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
