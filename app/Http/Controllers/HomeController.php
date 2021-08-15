<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
//thư viện dùng session
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect; // trả về
session_start();


class HomeController extends Controller
{
    public function index(){
        $cate_product= DB::table('tbl_category_product')->where('category_status','0')->orderBy('category_id','desc')->get();
        $brand_product= DB::table('tbl_brand_product')->where('brand_status','0')->orderBy('brand_id','desc')->get();

       // $all_product = DB::table('tbl_product')
        //->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        //->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')->orderby('product_id','desc')->get();

        $all_product = DB::table('tbl_product')->where('product_status',0)->orderby('product_id','desc')->limit(6)->get();

        return view('pages.home')->with('category',$cate_product)->with('brand',$brand_product)->with('all_product',$all_product);
    }
}
