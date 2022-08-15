<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Blog;

class HomeController extends Controller
{
    // Chuyển đến trang chủ
    public function index(){
        $days = 30;
        $list_category = Category::get();
        $list_brand = Brand::get();
        $list_blog = Blog::where('Status','1')->get();

        $list_new_pd = Product::join('productimage','productimage.idProduct','=','product.idProduct')
            ->whereRaw('Product.created_at >= NOW() - INTERVAL ? DAY', [$days])->where('StatusPro','1')->get();

        $list_featured_pd = Product::join('productimage','productimage.idProduct','=','product.idProduct')
        ->whereRaw('Product.created_at >= NOW() - INTERVAL ? DAY', [$days])
        ->where('StatusPro','1')->orderBy('Sold','DESC')->get();

        $list_bestsellers_pd = Product::join('productimage','productimage.idProduct','=','product.idProduct')
        ->where('StatusPro','1')->orderBy('Sold','DESC')->get();
            
        return view('shop.home')->with(compact('list_category','list_brand','list_new_pd','list_featured_pd','list_bestsellers_pd','list_blog'));
    }
}
