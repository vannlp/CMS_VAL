<?php

namespace App\Http\Controllers\Settings;

use App\DataTables\RoleDataTable;
use App\Facades\Permission;
use App\Http\Controllers\Controller;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PermissionController extends Controller
{
    public function __construct(protected RoleRepository $roleRepository) {}
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("pages.settings.permission.index");
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable() {
        return (new RoleDataTable())->build();
    }
    
    /**
     * Get all permission ajax
     * 
     */
    public function getPermissionByUser(Request $request) {
        $permissions = Permission::getPermission();
        $role = auth()->user()->role;
        $permissionUser = $role->permissions;
        
        
        
        $permissions = $permissions->map(function($item) use ($permissionUser, $role) {
            
            if(in_array($item['code'], $permissionUser) || $role->permission_type == 'all') {
                $item['is_active'] = true;
            } else {
                $item['is_active'] = false;
            }
            
            return $item;
        });
        
        return jsonRes()->responseWithData(__('app.base.get_data_success'), $permissions, 200);
    }
    
    /**
     * create new role
     * 
     */
    public function createRole(Request $request) {  
        $request->validate([
            'name' => ['required', 'string', 'unique:roles'],
            'permissions' => ['required', 'string']
        ]);
        
        $input = $request->all();
        
        if(is_string($input['permissions'])) {
            $input['permissions'] = json_decode($input['permissions']);
        }
        
        try {
            DB::beginTransaction();
            $role = $this->roleRepository->create($input);
            DB::commit();
            return redirect()->back()->with('message', __('app.base.create_data_success'));
        } catch (\Throwable $th) {
            //throw $th;
            Log::error("RoleController::createRole", [
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'message' => $th->getMessage()
            ]);
            DB::rollBack();
            return redirect()->back()->with('error_message', __('app.base.create_data_error'));
        }
    }
    
    /**
     * get one role
     * 
     */
    public function getRole(Request $request, $id) {
        $role = $this->roleRepository->find($id);
        
        return jsonRes()->responseWithData(__('app.base.get_data_success'), $role, 200);
    }
    
    /**
     * Update role
     * 
     */
    public function updateRole(Request $request, $id) {
        $request->validate([
            'name' => ['required', 'string'],
            'permissions' => ['required', 'string']
        ]);
        
        $input = $request->only(['name', 'permissions', 'description']);
        
        if(is_string($input['permissions'])) {
            $input['permissions'] = json_decode($input['permissions']);
        }
        
        try {
            DB::beginTransaction();
            $role = $this->roleRepository->find($id);
            
            $role = $role->update($input);
            DB::commit();
            return redirect()->back()->with('message', __('app.base.update_data_success'));
        } catch (\Throwable $th) {
            //throw $th;
            Log::error("RoleController::updateRole", [
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'message' => $th->getMessage()
            ]);
            DB::rollBack();
            return redirect()->back()->with('error_message', __('app.base.update_data_error'));
        }
    }
}