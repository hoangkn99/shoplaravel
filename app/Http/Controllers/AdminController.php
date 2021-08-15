<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
//thư viện dùng session
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect; // trả về
session_start();


class AdminController extends Controller
{
    public function AuthLogin(){
        $admin_id= Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function index(){
        return view('admin_login'); // hiển thị trang admin
    }
    public function show_dashboard(){
        $this->AuthLogin();
        return view('admin.dashboard'); //hiển thị trang dashboard
    }
    public function dashboard(request $request){
        $admin_name=$request->get('admin_name');
        $admin_password = md5($request->admin_password);
        $result = DB::table('tbl_admin')->where('admin_email',$admin_name)->where('admin_password',$admin_password)->first();
        if($result){
            Session::put('admin_name',$result->admin_name);
            Session::put('admin_id',$result->admin_id);
            return Redirect::to('/dashboard');

        }else{
            Session::put('message','Mật khẩu hoặc tài khoản không hợp lệ');
            return Redirect::to('/admin');
        }
    }

    public function logout(){
        $this->AuthLogin();
        Session::put('admin_name',null);
        Session::put('admin_id',null);
        return Redirect::to('/admin');

    }
}
