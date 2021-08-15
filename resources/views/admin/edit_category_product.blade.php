@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhật danh mục sản phẩm
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
                        @foreach($edit_category_product as $key => $edit_value)
                    <form role="form" action="{{URL::to('/update-category-product/'.$edit_value->category_id)}}" method="post">
                        {{  csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên danh mục</label>
                            <input type="text" value="{{$edit_value->category_name}}" name="category_product_name" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả danh mục</label>
                            <textarea style="resize:none" rows="5" type="password" class="form-control" id="exampleInputPassword1" name="category_product_desc">{{$edit_value->category_desc}}</textarea>
                        </div>
                        <button type="submit" class="btn btn-info" name="add_category_product">Cập nhật danh mục</button>
                    </form>
                    </div>
                    @endforeach
                </div>
            </section>
        </div>
</div>
@endsection