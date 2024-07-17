@extends('shop_layout')
@section('content')

<!--Page Banner Start-->
<div class="page-banner" style="background-image: url(public/kidolshop/images/banner/banner-shop.png);">
    <div class="container">
        <div class="page-banner-content text-center">
            <h2 class="title">Cart</h2>
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{URL::to('/home')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cart</li>
            </ol>
        </div>
    </div>
</div>
<!--Page Banner End-->

<!--Empty Cart Start-->
<div class="empty-cart-page section-padding-5">
    <div class="container">
        <div class="empty-cart-content text-center d-flex flex-column align-items-center">
            <div class="empty-cart-img">
                <img src="public/kidolshop/images/cart.png" alt="">
            </div>
            <p>Your cart is currently empty.</p>
            <a href="{{URL::to('/store')}}" class="btn btn-primary"><i class="fa fa-angle-left"></i>Continue Shopping</a>
        </div>
    </div>
</div>
<!--Empty Cart End-->

@endsection