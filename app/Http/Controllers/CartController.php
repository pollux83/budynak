<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use App\OrderDetail;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

use App\ListBrand;
use App\ListProduct;
use App\Page;
use App\Information;
use App\ListBlog;
use App\RequestCustomer;


class CartController extends Controller
{
    function __construct()
    {
        if(!session()->has('url_cart_budynak')) {
            $referer = $_SERVER['HTTP_REFERER'];
            $count = count(explode('cart', $referer));
            if($count <= 1) session()->put('url_cart_budynak', secure_url($_SERVER['HTTP_REFERER']));
        }

        $mainmenu = \Storage::get('mainmenu.json');
        $categories = \Storage::get('categories.json');
        $brand = \Storage::get('brand.json');

        $requests = RequestCustomer::where('status', 1)->orderBy('created_at', 'DESC')->limit(1)->get();
        //$brand = ListBrand::with('alias_brand')/*->where('status', '1')*/
        //->limit(5)->offset(1)->get();
        $info = Information::with('alias_information')->get();
        $post = ListBlog::with('alias_post')->where('status', '1')->limit(2)->offset(0)->orderBy('created_at', 'desc')->get();

        $page = new Page();
        $page->title = 'Заказ';
        $page->name = 'Заказ';
        $page->meta_description = '';
        $page->keywords = '';
        $page->alias = 'cart';

        $categories = json_decode($categories);
        $raspr = array_pop($categories);

        View::share([
            'mainmenu' => json_decode($mainmenu),
            'brands' => json_decode($brand),
            'cur_alias' => '',
            'requests' => $requests,
            'info' => $info,
            'post' => $post,
            'cat' => $categories,
            'page' => $page,            
            'raspr' => $raspr,
        ]);
    }

    public function show(){
        return view('cart', ['customerResult' => null]);
    }

    public function make(Request $request){
        $customer = $request->only('email', 'name', 'contact_number', 'delivery_address');
        $customer = $this->protect($customer);
        $customerResult = Customer::create($customer);
        $order = [];
        $order['total_amount'] = $this->getDecimal($_POST['total_amount']);
        $order['status'] = 1;
        $order['customer_id'] = $customerResult['id'];
        $order = $this->protect($order);
        $result = Order::create($order);
        foreach($_POST['product'] as $product){
            $orderDet = [];
            $arr = explode('|', $product);
            $orderDet['name'] = $arr[0];
            $orderDet['price'] = $this->getDecimal($arr[1]);
            $orderDet['quantity'] = $arr[2];
            $orderDet['order_id'] = $result['id'];
            $orderDet = $this->protect($orderDet);
            OrderDetail::create($orderDet);
        }
        session()->forget('url_cart_budynak');
        return view('cart', ['customerResult' => $customerResult]);
    }

    private function getDecimal($val){
        $arr = explode(' ', $val);
        if(count($arr) > 2)  return $arr[0].'.'.$arr[2];
        else return $arr[0];
    }
    private function protect($arr){
        foreach($arr as $key => $val){
            $val = trim($val);
            $val = stripslashes($val);
            $val = htmlspecialchars($val);
            $arr[$key] = $val;
        }
        return $arr;
    }
}
