<?php
namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

abstract class BaseDataTable {
    protected $query;
    protected $columns = [];
    protected $rawColumns = [];
    protected $dataTable;
    
    public function __construct()
    {
       $this->query = $this->modelQuery();
    }
    
    abstract public function modelQuery();
    
    public function query($query) {
    }
    
    public function editColumn($dataTable) {
        
    }
    
    public function build() {
        $this->query($this->query);
        $this->dataTable = DataTables::of($this->query);
        $this->dataTable->only($this->columns);
        $this->dataTable->rawColumns($this->rawColumns);
        $this->editColumn($this->dataTable);
        return $this->dataTable->toJson();
    }
}