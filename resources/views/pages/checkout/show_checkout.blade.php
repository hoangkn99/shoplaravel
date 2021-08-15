@extends('layout')
@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
              <li class="active">Thanh toán</li>
            </ol>
        </div>
       

        <div class="register-req">
            <p>Vui lòng đăng ký để bắt đầu mua hàng nha quý vị !!!</p>
        </div><!--/register-req-->

        <div class="shopper-informations">
            <div class="row">
                
                <div class="col-sm-10 clearfix">
                    <div class="bill-to">
                        <p>Điền thông tin mua hàng</p>
                        <div class="form-one">
                            <form action="{{URL::to('/save-checkout-customer')}}" method="POST">
                                {{ csrf_field() }}
                                <input name="shipping_email" type="text" placeholder="Email">
                                <input name="shipping_name" type="text" placeholder="Họ và tên">
                                <input name="shipping_address" type="text" placeholder="Địa chỉ">
                                <input name="shipping_phone" type="text" placeholder="Phone">
                                <textarea name="shipping_notes"  placeholder="Ghi chú đơn hàng của bạn" rows="16"></textarea>
                                <input type="submit" value="Gửi" name="send_order" class="btn btn-primary btn-sm">
                      
                            </form>
                        </div>
                        <div class="form-two">
                           
                        </div>
                    </div>
                </div>
                			
            </div>
        </div>
        <div class="review-payment">
            <h2>Xem lại giỏ hàng</h2>
        </div>

      
        <div class="payment-options">
                <span>
                    <label><input type="checkbox"> Direct Bank Transfer</label>
                </span>
                <span>
                    <label><input type="checkbox"> Check Payment</label>
                </span>
                <span>
                    <label><input type="checkbox"> Paypal</label>
                </span>
            </div>
    </div>
</section> <!--/#cart_items-->
@endsection