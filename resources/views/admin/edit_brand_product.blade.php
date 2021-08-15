@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhật thương hiệu sản phẩm
                </header>
                <div class="panel-body">
                   <p id="center1"> <?php
				    $message=Session::get('message');
				    if($message){
					    echo $message;
					Session::put('message',null);
				    }
				?></p>
                    <div class="position-center">
                        @foreach($edit_brand_product as $key => $edit_value)
                    <form role="form" action="{{URL::to('/update-brand-product/'.$edit_value->brand_id)}}" method="post">
                        {{  csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên thương hiệu</label>
                            <input type="text" value="{{$edit_value->brand_name}}" name="brand_product_name" class="form-control" id="exampleInputEmail1" placeholder="Tên thương hiệu">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả thương hiệu</label>
                            <textarea style="resize:none" rows="5" type="password" class="form-control" id="exampleInputPassword1" name="brand_product_desc">{{$edit_value->brand_desc}}</textarea>
                        </div>
                        <button type="submit" class="btn btn-info" name="add_brand_product">Cập nhật thương hiệu</button>
                    </form>
                    </div>
                    @endforeach
                </div>
            </section>
        </div>
</div>
@endsection