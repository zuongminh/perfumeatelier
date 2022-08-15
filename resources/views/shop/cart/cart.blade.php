@extends('shop_layout')
@section('content')

<!--Page Banner Start-->
<div class="page-banner" style="background-image: url(public/kidolshop/images/banner/banner-shop.png);">
    <div class="container">
        <div class="page-banner-content text-center">
            <h2 class="title">Giỏ Hàng</h2>
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{URL::to('/home')}}">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Giỏ Hàng</li>
            </ol>
        </div>
    </div>
</div>
<!--Page Banner End-->

<form id="form-payment">
    @csrf
<!--Cart Start-->
<div class="cart-page section-padding-5">
    <div class="container">
        <div class="cart-table table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th class="image">Hình Ảnh</th>
                        <th class="product">Sản Phẩm</th>
                        <th class="price">Giá</th>
                        <th class="quantity">Số Lượng</th>
                        <th class="total">Tổng</th>
                        <th class="remove">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $Total = 0; ?>
                    @foreach($list_pd_cart as $key => $pd_cart)
                        <?php $Total += ($pd_cart->PriceNew * $pd_cart->QuantityBuy); ?>
                    <tr class="product-item">
                        <?php $image = json_decode($pd_cart->ImageName)[0]; ?>
                        <td class="image">
                            <a href="{{URL::to('/shop-single/'.$pd_cart->ProductSlug)}}"><img src="{{asset('public/storage/kidoldash/images/product/'.$image)}}" alt=""></a>
                        </td>
                        <td class="product">
                            <a href="{{URL::to('/shop-single/'.$pd_cart->ProductSlug)}}">{{$pd_cart->ProductName}}</a>
                            <span>Mã sản phẩm: {{$pd_cart->idProduct}}</span>
                            <span>{{$pd_cart->AttributeProduct}}</span>
                            <span class="text-primary">Còn Lại: {{$pd_cart->Quantity}}</span>
                            <?php $replace = [" ",":"]; ?>
                            <input type="hidden" class="Quantity" id="<?php echo 'Quantity-'.$pd_cart->idProduct.'-'.str_replace($replace,"",$pd_cart->AttributeProduct);?>" value="{{$pd_cart->Quantity}}">
                        </td>
                        <td class="price">
                            <span class="amount">{{number_format($pd_cart->PriceNew,0,',','.')}}đ</span>
                        </td>
                        <td class="quantity">
                            <div class="quantity d-inline-flex">
                                <button type="button" class="sub-qty" id="sub-qty-{{$pd_cart->idProduct}}-{{$pd_cart->AttributeProduct}}"><i class="ti-minus"></i></button>
                                <input type="number" class="QuantityBuy" id="QuantityBuy-{{$pd_cart->idProduct}}" value="{{$pd_cart->QuantityBuy}}" min="1" oninput="validity.valid||(value='1');"/>
                                <button type="button" class="add-qty" id="{{$pd_cart->idProduct}}-{{$pd_cart->AttributeProduct}}"><i class="ti-plus"></i></button>
                                <div class="alert-qty-input"><span class="message-qty-input">Mua tối đa {{$pd_cart->Quantity}} sản phẩm!</span></div>
                                <input type="hidden" value="{{$pd_cart->idCart}}">
                                <input type="hidden" value="{{$pd_cart->PriceNew}}">
                                <input type="hidden" value="{{$pd_cart->Quantity}}">
                            </div>
                        </td>
                        <td class="total">
                            <span class="total-amount">{{number_format($pd_cart->Total,0,',','.')}}đ</span>
                        </td>
                        <td class="remove">
                            <a class="view-hover delete-pd-cart" data-id="{{$pd_cart->idCart}}" data-token="{{csrf_token()}}"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="cart-btn">
            <div class="cart-btn-left">
                <a href="{{URL::to('/store')}}" class="btn btn-primary">Tiếp tục mua sắm</a>
            </div>
            <div class="cart-btn-right">
                <a href="{{URL::to('/delete-cart')}}" class="btn">Xóa giỏ hàng</a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="cart-totals">
                    <div class="cart-title">
                        <h4 class="title">Tổng giỏ hàng</h4>
                    </div>
                    <div class="cart-total-table mt-25">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        <p class="value">Thành Tiền</p>
                                    </td>
                                    <td>
                                        <p class="price">{{number_format($Total,0,',','.')}}đ</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="cart-total-btn">
                        <a href="{{URL::to('/payment')}}" class="btn btn-primary btn-block btn-payment">Thanh toán</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Cart End-->
</form>

<script>
    $(document).ready(function()
    {
        // Cập nhật số lượng khi click "+"
        $('.add-qty').on('click',function(){
            var id = $(this).attr("id");
            var id_replace = id.replace(/ /g,"").replace(/:/g,"");

            var Quantity = parseInt($('#Quantity-'+id_replace).val());
            var $input = $(this).prev();
            var currentValue = parseInt($input.val());
            if(currentValue >= Quantity){
                $alert_element = $(this).next();

                $alert_element.css({'transform' : 'scale(1)', 'opacity' : '1'});
                setTimeout(function () {
                    $alert_element.css({'transform' : 'scale(0)', 'opacity' : '0'});
                }, 1000);
            }else{
                $input.val(currentValue + 1);
                var idCart = $(this).nextAll().eq(1).val();
                var PriceNew = $(this).nextAll().eq(2).val();
                var Quantity = $(this).nextAll().eq(3).val();
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url: '{{url("/update-qty-cart")}}',
                    method: 'POST',
                    data: {idCart:idCart,QuantityBuy:$input.val(),PriceNew:PriceNew,Quantity:Quantity,_token:_token},
                    success:function(data){
                        location.reload();
                    }
                });
            }
        });

        // Cập nhật số lượng khi click "-"
        $('.sub-qty').on('click',function(){
            var $input = $(this).next();
            var currentValue = parseInt($input.val());
 
            if(currentValue > 1){
                $input.val(currentValue - 1);
                var idCart = $(this).nextAll().eq(3).val();
                var PriceNew = $(this).nextAll().eq(4).val();
                var Quantity = $(this).nextAll().eq(5).val();
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url: '{{url("/update-qty-cart")}}',
                    method: 'POST',
                    data: {idCart:idCart,QuantityBuy:$input.val(),PriceNew:PriceNew,Quantity:Quantity,_token:_token},
                    success:function(data){
                        location.reload();
                    }
                });
            }
            
            $(this).nextAll().eq(2).css({'transform' : 'scale(0)', 'opacity' : '0'});
        });

        // Cập nhật QuantityBuy khi sửa số lượng trong input
        $("input[type='number']").bind("focus", function () {
            var value = parseInt($(this).val());

            $(this).bind("blur", function() {
                var id = $(this).next().attr("id");
                var id_replace = id.replace(/ /g,"").replace(/:/g,"");
                var Quantity = parseInt($('#Quantity-'+id_replace).val());

                if(value != parseInt($(this).val()) && Quantity >= $(this).val()) {
                    var idCart = $(this).nextAll().eq(2).val();
                    var PriceNew = $(this).nextAll().eq(3).val();
                    var Quantity = $(this).nextAll().eq(4).val();
                    var _token = $('input[name="_token"]').val();
                    
                    $.ajax({
                        url: '{{url("/update-qty-cart")}}',
                        method: 'POST',
                        data: {idCart:idCart,QuantityBuy:$(this).val(),PriceNew:PriceNew,Quantity:Quantity,_token:_token},
                        success:function(data){
                            location.reload();
                        }
                    });
                }else{
                    $(this).unbind("blur");
                    $(this).nextAll().eq(1).css({'transform' : 'scale(1)', 'opacity' : '1'});
                    setTimeout(function () {
                        $(".alert-qty-input").css({'transform' : 'scale(0)', 'opacity' : '0'});
                    }, 3000);
                }
            });
        });

        // Kiểm tra QuantityBuy khi click thanh toán
        $('.btn-payment').on('click',function(e){
            $("#form-payment .product-item").each(function() {
                var Quantity = parseInt($(".Quantity", this).val());
                var QuantityBuy = parseInt($(".QuantityBuy", this).val());

                if(QuantityBuy > Quantity){
                    $(".alert-qty-input", this).css({'transform' : 'scale(1)', 'opacity' : '1'});
                    setTimeout(function () {
                        $(".alert-qty-input").css({'transform' : 'scale(0)', 'opacity' : '0'});
                    }, 3000);
                    $("html, body").animate({scrollTop : ($(".alert-qty-input", this).position().top + 200)}, "fast");
                    e.preventDefault();
                }
            });
        });
    });  
</script>

@endsection