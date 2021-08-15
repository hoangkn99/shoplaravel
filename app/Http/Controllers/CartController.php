<?php

namespace App\Http\Controllers;
use Cart;
use Illuminate\Http\Request;
use DB;
//thư viện dùng session
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect; // trả về
session_start();

class CartController extends Controller
{

    public function gio_hang(Request $request){
        $meta_desc="Giỏ hàng của bạn";
        $meta_keywords="Giỏ hàng ajax";
        $meta_title="Giỏ hàng ajax";
        $url_canonical=$request->url();

        $cate_product= DB::table('tbl_category_product')->where('category_status','0')->orderBy('category_id','desc')->get(); // lấy danh mục
        $brand_product= DB::table('tbl_brand_product')->where('brand_status','0')->orderBy('brand_id','desc')->get(); // lấy thương hiệu sản phẩm

        return view('pages.cart.cart_ajax')->with('category',$cate_product)->with('brand',$brand_product)
        ->with('meta_desc',$meta_desc)->with('meta_keyworks',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);


    }

    public function add_cart_ajax(Request $request){
        $data = $request->all();
        $session_id= substr(md5(microtime()),rand(0,26),5);
        $cart = Session::get('cart');
        if($cart==true){
            $is_avaiable= 0;
            foreach($cart as $key =>$val){
                if($val['product_id']==$data['cart_product_id']){
                    $is_avaiable++;
                }

        }
        if($is_avaiable == 0){
                $cart[]= array(
                    'session_id' => $session_id,
                    'product_name' => $data['cart_product_name'],
                    'product_id' => $data['cart_product_id'],
                    'product_image' => $data['cart_product_image'],
                    'product_price' => $data['cart_product_price'],
                    'product_qty' => $data['cart_product_qty'],
                );
                Session::put('cart',$cart);
            }
        }else{
            $cart[]= array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_price' => $data['cart_product_price'],
                'product_qty' => $data['cart_product_qty'],
            );
        }
            Session::put('cart',$cart);
            Session::save();
            
    }
    public function update_cart(Request $request){
        $data=$request->all();
        $cart= Session::get('cart');
        if($cart==true){
            foreach($data['cart_qty'] as $key =>$qty){
                foreach($cart as $session =>$value){
                    if($value['session_id']==$key){
                        $cart[$session]['product_qty']=$qty;
                    }
                }
            }
            Session::put('cart',$cart);
            return Redirect()->back()->with('message','cập nhật số lượng sản phẩm thành công');
        }else{
            return Redirect()->back()->with('message','Cập nhật số lượng sản phẩm thất bại');
        }
    }
    public function save_cart(Request $request){
        $cate_product= DB::table('tbl_category_product')->where('category_status','0')->orderBy('category_id','desc')->get(); // lấy danh mục
        $brand_product= DB::table('tbl_brand_product')->where('brand_status','0')->orderBy('brand_id','desc')->get(); // lấy thương hiệu sản phẩm

        $product_id= $request->product_id_hidden;
        $quantity=$request->qty;
        $product_infor= DB::table('tbl_product')->where('product_id',$product_id)->first();

        Cart::add('293ad', 'Product 1', 1, 9.99, 550);

        return view('pages.cart.show_cart')->with('category',$cate_product)->with('brand',$brand_product);

    }
    public function del_product($session_id){
        $cart= Session::get('cart');
        if($cart==true){
            foreach($cart as $key => $value){
                if($value['session_id']==$session_id){
                    unset($cart[$key]);
                }
            }
            Session::put('cart',$cart);
            return Redirect()->back()->with('message','xóa sản phẩm thành công');
        }else{
            return Redirect()->back()->with('message','xóa sản phẩm thất bại');
        }
    }
    public function del_all_product(){
        $cart=Session::get('cart');
            if($cart==true){
                Session::forget('cart');
                return Redirect()->back()->with('message','xóa hết sản phẩm thành công');
            }
        
    }
}