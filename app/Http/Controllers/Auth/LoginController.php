<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * hàm xử lý đăng nhập admin
     * 
     */
    public function handleLoginAdmin(Request $request) {
        // Lấy thông tin từ form (có thể là email hoặc username)
        $login = $request->input('email-username');
        $password = $request->input('password');

        // Kiểm tra xem người dùng nhập vào email hay username
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Xây dựng credentials phù hợp
        $credentials = [
            $fieldType => $login,
            'password' => $password,
        ];
        
        if (Auth::attempt($credentials, $request->has('remember'))) {
            // Authentication passed...
            return redirect()->intended('/admin');
        }
        
        return back()->withErrors([
            'login_error' => __("app.auth.login_error"),
        ]);
    }
    
    /**
     * màn hình đăng nhập admin
     * 
     */
    public function loginAdmin(Request $request) {
        $pageConfigs['myLayout'] = 'blank';
        Helpers::updatePageConfig($pageConfigs);
        return view('pages.auth.login');
    }
}
