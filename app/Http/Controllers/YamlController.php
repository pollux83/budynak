<?php

namespace App\Http\Controllers;

//use Faker\Provider\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;

class YamlController extends Controller
{
    private $path;

    function __construct()
    {
        $this->path = public_path() . '/' . 'yamarket.yml';
    }

    public function index(){
        $this->generateYML();
        return File::get($this->path);
    }

    public function generateYML(){
        $categories = \Storage::get('categories.json');
        $categories = json_decode($categories);
        $products = DB::select('SELECT
              categories.id AS catId,
              list_products.name,
              categories_1.name AS vendor,
              list_products.price,
              aliases_products.alias,
              aliases_categories.alias AS par_alias
            FROM list_products
              INNER JOIN product_categories
                ON list_products.id = product_categories.product_id
              INNER JOIN categories
                ON product_categories.category_id = categories.id
              INNER JOIN product_categories product_categories_1
                ON list_products.id = product_categories_1.product_id
              INNER JOIN categories categories_1
                ON product_categories_1.category_id = categories_1.id
              INNER JOIN aliases_products
                ON aliases_products.id = list_products.id
              INNER JOIN aliases_categories
                ON categories.id = aliases_categories.id
            WHERE list_products.status = 1
            AND categories_1.brand = 1
            AND categories.id = categories.category');
        $record = '<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE yml_catalog SYSTEM "shops.dtd">';
        $record .= '<yml_catalog date="'.date('Y-m-d h:m').'">';
        $record .= '<shop>
        <name>budynak.by</name>
        <company>ИП Солоневич А.Н.</company>
        <url>https://budynak.by/</url>
        <currencies>
            <currency id="BYN" rate="1"/>
        </currencies>
        <categories>';
        if(File::exists($this->path)) File::delete($this->path);
        File::append($this->path, $record);
        $record = null;
        foreach($categories as $cat){
            $record .= '<category id="'.$cat->id.'">'.$cat->name.'</category>';
        }
        $record .= '</categories>
        <delivery-options>
            <option cost="15" days="3-5" order-before="1"/>
        </delivery-options>
        <offers>';
        File::append($this->path, $record);
        $record = null;
        foreach($products as $key => $prod){
            $vendor = preg_replace('/Двери /u', '', $prod->vendor);
            $record .= '\r\n<offer id="'. $key .'" type="vendor.model" available="true">
                <url>' . secure_url($prod->par_alias.'/'.$prod->alias) .'</url>
                <currencyId>BYN</currencyId>
                <categoryId>'. $prod->catId .'</categoryId>
                <delivery>true</delivery>
                <vendor>'. trim($vendor) .'</vendor>
                <price>'. round($prod->price, 2) .'</price>
                <model>'. $prod->name .'</model>
                <manufacturer_warranty>true</manufacturer_warranty>
            </offer>';
        }
        File::append($this->path, $record);
        $record = '</offers>
    </shop>
</yml_catalog>';
        File::append($this->path, $record);

        /*return view('admin.yaml', [
            'categories' => $categories,
            'products' => $products
        ]);*/
    }
}
