<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $slider;
    private $category;
    private $product;

    public function __construct(Slider $slider, Category $category, Product $product)
    {
        $this->slider = $slider;
        $this->category = $category;
        $this->product = $product;
    }

    public function index()
    {
        $sliders = $this->slider->latest()->get();
        $categorys = $this->category->where('parent_id', 0)->get();
        $products = $this->product->latest()->take(6)->get();
        $productsRecommend = $this->product->latest('views_count', 'desc')->take(9)->get();
        $categoryLimits = $this->category->where('parent_id', 0)->take(3)->get();
        //Lấy số lượng sản phẩm đã thêm để hiển thị lên thẻ cart
        $cartsNumber = count(session()->get('cart'));
        return view('frontend.home.home', compact('sliders', 'categorys', 'products', 'productsRecommend', 'categoryLimits','cartsNumber'));
    }
}
