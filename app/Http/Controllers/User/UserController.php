<?php

namespace App\Http\Controllers\User;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(protected UserRepository $userRepository) {}

    public function index (Request $request) {
        $request->ajax();
        $roles = Role::all();
        return view("pages.user.index", [
            'roles' => $roles
        ]);
    }

    public function datatable() {
        return (new UserDataTable())->build();
    }
    
    public function getOne(Request $request, $id) {
        $user = $this->userRepository->find($id);
        
        return jsonRes()->responseWithData(__('app.base.get_data_success'), $user, 200);
    }
    
    public function update($id, Request $request) {
        $user = $this->userRepository->find($id);
        
        $request->validate([
            're_new_password' => ['nullable', 'same:new_password']
        ]);
        
        $input = $request->all();
        
        if(!$request->status) {
            $input['status'] = 0;
        } else {
            $input['status'] = 1;
        }
        
        try {
            DB::beginTransaction();
            if(!empty($input['name'])) {
                $user->name = $input['name'];
            }
            
            if(!empty($input['email'])) {
                $user->email = $input['email'];
            }
            
            if(!empty($input['new_password'])) {
                $user->password = Hash::make($input['new_password']);
            }
            
            if(!empty($input['role_id'])) {
                $user->role_id = $input['role_id'];
            }
            
            if(array_key_exists('status', $input)) {
                $user->status = $input['status'];
            }
            
            $user->save();
            DB::commit();
            
            return redirect()->back()->with('message', __('app.base.update_data_success'));
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->with('error_message', __('app.base.update_data_error'));
        }
    }
    
    public function delete($id) {
        try {
            DB::beginTransaction();
            $this->userRepository->find($id)->delete();
            DB::commit();
            
            return jsonRes()->responseWithMessage(__('app.base.delete_data_success'), 200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            Log::error("UserController::delete", [
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'message' => $th->getMessage()
            ]);
            return jsonRes()->responseWithMessage(__('app.base.delete_data_error'), 500);
        }
        
    }
    
    public function create(Request $request) {
        $request->validate([
            'username' => ['required', 'unique:users'],
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'role_id' => ['required']
        ]);
        
        $input = $request->all();
        
        try {
            DB::beginTransaction();
            $input['password'] = Hash::make($input['password']);
            $user = $this->userRepository->create($input);
            
            DB::commit();
            return redirect()->back()->with('message', __('app.base.create_data_success'));
        } catch (\Throwable $th) {
             //throw $th;
            DB::rollBack();
            dd($th);
            return redirect()->back()->with('error_message', __('app.base.create_data_error'));
        }
    }
}
