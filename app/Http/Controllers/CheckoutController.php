<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
//thư viện dùng session
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect; // trả về
session_start();

class CheckoutController extends Controller
{
    public function AuthLogin(){
        $admin_id= Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

    public function login_checkout(){

        $cate_product= DB::table('tbl_category_product')->where('category_status','0')->orderBy('category_id','desc')->get(); // mooiw trang deu co thuong hieu va danh muc
        $brand_product= DB::table('tbl_brand_product')->where('brand_status','0')->orderBy('brand_id','desc')->get();

        return view('pages.checkout.login_checkout')->with('category',$cate_product)->with('brand',$brand_product);
    }

    public function add_customer(Request $request){
        $data = array();
        $data['customer_name']=$request->customer_name;
        $data['customer_email']=$request->customer_email;
        $data['customer_password']=md5($request->customer_password);
        $data['customer_phone']=$request->customer_phone;

        $customer_id=DB::table('tbl_customers')->insertGetid($data); //insertgetid >> lấy id vừa insert vào

        Session::put('customer_id',$customer_id);
        Session::put('customer_name',$request->customer_name);
        return Redirect::to('/checkout');
    }
    public function checkout(){
        $cate_product= DB::table('tbl_category_product')->where('category_status','0')->orderBy('category_id','desc')->get(); // mooiw trang deu co thuong hieu va danh muc
        $brand_product= DB::table('tbl_brand_product')->where('brand_status','0')->orderBy('brand_id','desc')->get();

        return view('pages.checkout.show_checkout')->with('category',$cate_product)->with('brand',$brand_product);
    }
    public function save_checkout_customer(Request $request){
        $data = array();
        $data['shipping_name']=$request->shipping_name;
        $data['shipping_email']=$request->shipping_email;
        $data['shipping_notes']=$request->shipping_notes;
        $data['shipping_phone']=$request->shipping_phone;
        $data['shipping_address']=$request->shipping_address;

        $shipping_id=DB::table('tbl_shipping')->insertGetid($data); //insertgetid >> lấy id vừa insert vào

        Session::put('shipping_id',$shipping_id);
        return Redirect::to('/payment');
    }

    public function payment(){
        $cate_product= DB::table('tbl_category_product')->where('category_status','0')->orderBy('category_id','desc')->get(); // mooiw trang deu co thuong hieu va danh muc
        $brand_product= DB::table('tbl_brand_product')->where('brand_status','0')->orderBy('brand_id','desc')->get();
        return view('pages.checkout.payment')->with('category',$cate_product)->with('brand',$brand_product);
    }

    public function logout_checkout(){
        Session::flush();
        return Redirect::to('/login-checkout');

    }
    public function login_customer(Request $request){
        $email=$request->email_account;
        $password=md5($request->password_account);

        $result=DB::table('tbl_customers')->where('customer_email',$email)->where('customer_password',$password)->first();

        if($result){
            Session::put('customer_id',$result->customer_id);
            return Redirect('/checkout');
         
        }else{
            
            return Redirect::to('/login-checkout');
        }
      
       
    }

    public function order_place(Request $request){
        $cate_product= DB::table('tbl_category_product')->where('category_status','0')->orderBy('category_id','desc')->get(); // mooiw trang deu co thuong hieu va danh muc
        $brand_product= DB::table('tbl_brand_product')->where('brand_status','0')->orderBy('brand_id','desc')->get();
    //lấy phương thức thanh toán
        $data = array();
        $data['payment_method']=$request->payment_option;
        $data['payment_status']='Đang chờ xử lí';
        $payment_id=DB::table('tbl_payment')->insertGetid($data);
        //insert order
        $order_data = array();
        $order_data['customer_id']=Session::get('customer_id');
        $order_data['shipping_id']=Session::get('shipping_id');
        $order_data['payment_id']=$payment_id;
        $order_data['order_total']=$request->payment_total;
        $order_data['order_status']='Đang chờ xử lí';
        $order_id=DB::table('tbl_order')->insertGetid($order_data);
        //insert order_details
        $sessioncart=Session::get('cart');
        foreach($sessioncart as $key => $cart){
        $order_d_data['order_id']=$order_id;
        $order_d_data['product_id']=$cart['product_id'];
        $order_d_data['product_name']=$cart['product_name'];
        $order_d_data['product_price']=$cart['product_price'];
        $order_d_data['product_sale_quantity']=$cart['product_qty'];
       DB::table('tbl_order_details')->insertGetid($order_d_data); 
        }
      if($data['payment_method']==1){
          echo 'Thanh toán bằng thẻ ATM';
      }else{
        Session::forget('cart');
          return view('pages.checkout.finish_order')->with('category',$cate_product)->with('brand',$brand_product);
      }
       
       
        //return view('pages.checkout.order_place');
    }

    public function manage_order(){
        $this->AuthLogin();
        $all_order = DB::table('tbl_order')
        ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id') //kết order và customer, lấy tất cả order+tên
        ->select('tbl_order.*','tbl_customers.customer_name')
        ->orderby('tbl_order.order_id','desc')->get();
        $manager_order= view('admin.manage_order')->with('all_order',$all_order);
        return view('admin_layout')->with('admin.manage_order',$manager_order); // hiển thị với manager_order
    
      
    }

    public function view_order($order_id){
        $this->AuthLogin();
        $order_by_id = DB::table('tbl_order')
        ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id') //
        ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id') //
        ->join('tbl_order_details','tbl_order_details.order_id','=','tbl_order.order_id') //
        ->select('tbl_order.*','tbl_customers.*','tbl_shipping.*','tbl_order_details.*')->first();
        $product_by_id=DB::table('tbl_order')
        ->join('tbl_order_details','tbl_order_details.order_id','=','tbl_order.order_id')
        ->select('tbl_order_details.*')->get();
      $manager_order_by_id= view('admin.view_order')->with('order_by_id',$order_by_id)->with('product_by_id',$product_by_id);
        return view('admin_layout')->with('admin.view_order',$manager_order_by_id);

    }
}
