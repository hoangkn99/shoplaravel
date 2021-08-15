@extends('layout')
@section('content')


<section id="cart_items">
  
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
              <li class="active">Giỏ hàng</li>
            </ol>
        </div>
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{session()->get('message')}}
            </div>
        @elseif(session()->has('error'))
        <div class="alert alert-success">
            {{session()->get('error')}}
        </div>
        @endif
        <div class="table-responsive cart_info">
            <form action="{{URL('/update-cart')}}" method="POST">
                @csrf
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Hình ảnh</td>
                        <td class="description">Tên sản phẩm</td>
                        <td class="price">Giá</td>
                        <td class="quantity">Số lượng</td>
                        <td class="total">Thành tiền</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>

                    @if(Session::get('cart')==true)
                    @php
                    $total=0;
                @endphp
                  @foreach(Session::get('cart') as $key => $cart)
                 
                  @php
                     $subtotal=$cart['product_price']*$cart['product_qty'];
                     $total+=$subtotal;
                  @endphp
                    <tr>
                        <td class="cart_product">
                            <a href=""><img src="{{asset('public/uploads/product/'.$cart['product_image'])}}" width="100px" height="100px" alt=""></a>
                        </td>
                        <td class="cart_description">
                            <p>{{$cart['product_name']}}</p>
                        </td>
                        <td class="cart_price">
                            <p>{{number_format($cart['product_price'],0,',','.')."đ"}}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <input class="cart_quantity_button" id="inputwidth" type="number" min="1" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}" autocomplete="off" >
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">{{number_format($subtotal,0,',','.')."đ"}}</p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="{{URL::to('/del-product/'.$cart['session_id'])}}"><i class="fa fa-times"></i></a>
                         
                        </td>
                        
                    </tr>
                  
                    @endforeach
                    <tr> 
                        <td><input  type="submit" name="update_qty" value="cập nhật" size="5" class="btn btn-default check_out"></td>
                        <td>   <a class="btn btn-default check_out" href="{{URL('/del-all-product')}}">Xóa tất cả sản phẩm</a></td>
                    </tr>
                    <tr>
                        <td colspan="5">
                    <section id="do_action">
                        
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="total_area">
                                        <ul>
                                            <li>Tổng tiền:<span>{{number_format($total,0,',','.')."đ"}}</span></li>
                                            <li>Thuế<span></span></li>
                                            <li>Phí vận chuyển<span></span></li>
                                            <li>Tiền sau giảm<span></span></li>
                                        </ul>
                                        <?php
                                        $customer_id=Session::get('customer_id');
                                        if($customer_id==NULL){
                                    ?>
                                <a href="{{URL::to('/login-checkout')}}" class="btn btn-default check_out"><i ></i>Thanh toán</a>
                                    <?php 
                                        }else{
                                            ?>
                                        <a href="{{URL::to('/checkout')}}"  class="btn btn-default check_out"><i></i>Thanh toán</a>
                                        <?php 
                                        } 
                                            
                                        ?>
                                       
                                      
                                    </div>
                             
                            </div>
                        </div>       
                    </section> 
                </td>
                    </tr>
                    @else
                    <tr>
                        <td colspan="5"><center>
                        @php
                            echo 'Giỏ hàng chưa có sản phẩm nào!';
                        @endphp
                        </center></td>
                    </tr>
                    @endif
                </tbody>
            </table>
           
                           
        </form>
  
    </div>
</section> <!--/#cart_items-->

{{-- <section id="do_action">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="total_area">
                    <ul>
                        <li>Tổng tiền:<span>{{number_format($total,0,',','.')."đ"}}</span></li>
                        <li>Thuế<span></span></li>
                        <li>Phí vận chuyển<span></span></li>
                        <li>Tiền sau giảm<span></span></li>
                    </ul>
                    <a class="btn btn-default check_out" href="">Thanh toán</a>
                  
                </div>
            </div>
        </div>
    </div>       
</section> --}}

@endsection