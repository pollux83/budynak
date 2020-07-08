<?php

namespace App\Http\Controllers\EShopDataEntry;

use App\ListBrand;
use App\ProductDiscount;
use App\ProductOption;
use Illuminate\Http\Request;
use App\Http\Controllers\Seo\ImageOptimizeController;
//use App\Http\Requests;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Controller;
use App\Product;
use App\ListProduct;
use App\Brand;
use App\Category;
use App\ProductCategory;
use Illuminate\Support\Facades\DB;
use App\ProductOptionValue;
use App\AliasProduct;
use App\ProductImage;
//use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class ProductsController extends Controller
{

    public function index()
    {
        /*$product = DB::table('products')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->join('list_products', 'products.id', '=', 'list_products.id')
            ->select('products.*', 'brands.name as brand', 'list_products.status')
            ->groupBy('products.id')
            ->paginate(25);*/
        $product = DB::select('SELECT
              list_products.status,
              list_products.name,
              list_products.id,
              list_products.price,
              products.title
            FROM products
              RIGHT OUTER JOIN list_products
                ON products.id = list_products.id
            WHERE products.title IS NULL
            OR products.meta_description IS NULL
            OR products.keywords IS NULL
            OR products.description IS NULL');
        $page = null;
        $perPage = 25;
        $option = [];
        $page = $page ?: (LengthAwarePaginator::resolveCurrentPage() ?: 1);
        $product = $product instanceof Collection ? $product : Collection::make($product);
        $paginate = new LengthAwarePaginator($product->forPage($page, $perPage), $product->count(), $perPage, $page, $option);
        $paginate->setPath('products');
        return view('admin.e_shop_data_entry.products', ['products' => $paginate]);
    }

    public function create()
    {
        $brand = DB::table('list_brands')
            ->select('id', 'name')
            ->get();
        $category = DB::table('categories')
            ->select('id', 'name')
            ->get();
        $idProduct = DB::table('list_products')->max('id');
        return view('admin.e_shop_data_entry.create_product', [
            'brands' => $brand,
            'categories' => $category,
            'idProduct' => $idProduct + 1
        ]);
    }

    public function store(Request $request)
    {
        //optimize image
        list($pathCache, $filename) = $this->getPathImage();
        //save products
        $id = $_POST['product_id'];
        $check = Product::find($id);
        if(count($check) > 0) Product::destroy($id);
        $product = new Product;
        $product->id = $id;
        $product->name = $_POST['name'];
        $product->title = $_POST['title'];
        $product->description = $_POST['description'];
        $product->price = $_POST['price'];
        //$product->brand_id = $_POST['brand_id'];
        $product->meta_description = $_POST['meta_description'];
        $product->keywords = $_POST['keywords'];
        $product->save();
        //save list_products
        $check = ListProduct::find($id);
        if(count($check) > 0) ListProduct::destroy($id);
        $this->optimizeImage($pathCache);
        $prodList = new ListProduct;
        $prodList->id = $id;
        $prodList->name = $_POST['name'];
        $prodList->price = $_POST['price'];
        //$prodList->brand_id = $_POST['brand_id'];
        $prodList->status = $_POST['status'];
        $prodList->image = $filename;
        $prodList->sort = 0;
        $prodList->save();
        //save product_categories
        $prodCat = $request->only('product_id', 'category_id');
        $catId = $prodCat['category_id'];
        if (is_array($catId)) {
            $data['product_id'] = $prodCat['product_id'];
            foreach ($catId as $cat) {
                $data['category_id'] = $cat;
                ProductCategory::create($data);
            }
        } else ProductCategory::create($prodCat);
        //save в product_image
        $imageAr = $_POST['filepath'];
        foreach ($imageAr as $i => $img) {
            if (mb_strlen($img) > 0) {
                if(mb_strpos($img, 'https:') === 0 || mb_strpos($img, 'https:') > 0){
                    $img = explode('image/', $img)[1];
                }
                $productImage = new ProductImage;
                $productImage->product_id = (int)$id;
                $productImage->sort = $i;
                $productImage->image = $img;
                $productImage->save();
            }
        }
        //save into aliases
        $where = $request->only('alias');
        $where['id'] = $id;
        unset($where['product_id']);
        AliasProduct::create($where);
        Product::with('brand')->get();
        //save discount
        if (mb_strlen($_POST['discount'])) {
            if (array_key_exists('date_start', $_POST)) $where = $request->only('discount', 'date_end', 'date_start', 'product_id');
            else {
                $where = $request->only('discount', 'date_end');
                $where['date_start'] = date('Y-m-d');
            }
            ProductDiscount::create($where);
        }
        if (array_key_exists('oldId', $_POST)) return $this->editProductOptions($_POST['oldId'].'new'.$_POST['product_id']);
        else {
            $option = DB::table('option')
                ->select('id', 'name')
                ->get();
            $value = DB::table('value')
                ->select('id', 'name')
                ->where('option_id', '=', $option[0]->id)
                ->get();

            return view('admin.e_shop_data_entry.create_product_options', [
                'options' => $option,
                'values' => $value,
                'message' => 'Created product',
                'idProduct' => $_POST['product_id']
            ]);
        }
    }

    public function storeProductOptions()
    {
        $this->saveOptionValue();
        return back()->with('message', 'Options of the product created');
    }

    public function show($id)
    {
        if (array_key_exists('category', $_GET)) {
            $where['product_categories.category_id'] = $_GET['category'];
        } else $where['product_categories.category_id'] = $id;
        $product = DB::table('product_categories')
            ->join('list_products', 'product_categories.product_id', '=', 'list_products.id')
            ->join('products', 'product_categories.product_id', '=', 'products.id')
            ->select('list_products.id', 'list_products.name', 'list_products.price', 'list_products.status', 'products.title')
            ->where($where)
            ->paginate(50);
        $category = DB::select('SELECT
              categories.id,
              categories.name
            FROM categories
            WHERE categories.category = ?
             AND categories.id <> ?', [$id, $id]);
        return view('admin.e_shop_data_entry.products_cat', [
            'products' => $product,
            'categories' => $category,
            'parent' => $id
        ]);
    }

    public function changeValueAjax()
    {
        if (array_key_exists('id_option', $_POST)) {
            $idOption = $_POST['id_option'];
            $value = DB::table('value')
                ->select('id', 'name')
                ->where('option_id', '=', $idOption)
                ->get();
            foreach ($value as $val) {
                $arr[$val->id] = $val->name;
            }
            return $arr;
        } else return 'данные POST не получены';
    }

    public function changeTitleAjax($id)
    {
        if (array_key_exists('title', $_POST)) {
            $title = $_POST['title'];
            $result = DB::table('products')->where('id', $id)->update(['title' => $title]);
            if (!$result) {
                return;
            }
            return 'true';
        } else return;
    }

    public function changePriceAjax($id)
    {
        if (array_key_exists('price', $_POST)) {
            $price = (int)$_POST['price'];
            $result = DB::table('products')->where('id', $id)->update(['price' => $price]);
            if (!$result) {
                return;
            }
            $result = DB::table('list_products')->where('id', $id)->update(['price' => $price]);
            if (!$result) {
                return;
            }
            return 'true';
        } else return;
    }

    public function edit($id)
    {
        $idArr = explode('_', $id);
        if (count($idArr) > 1 && $idArr[1] == 'copy') {
            $newId = (DB::table('list_products')->max('id')) + 1;
        } else $newId = null;
        $brand = ListBrand::all();
        $product = Product::find($id);
        $listProduct = ListProduct::find($id);
        $prodCat = ProductCategory::where('product_id', $id)->get();
        foreach ($prodCat as $pc) {
            $whereCat[] = $pc->category_id;
        }
        $alias = AliasProduct::where(['id' => $id])->get();
        $prodCat = DB::table('categories')
            ->whereIn('id', $whereCat)
            ->get();
        $category = DB::table('categories')
            ->whereNotIn('id', $whereCat)
            ->get();
        $image = DB::table('product_image')->select('image', 'sort')->where('product_id', $id)->orderBy('sort')->get();
        $productDiscount = ProductDiscount::where('product_id', $id)->get();
        return view('admin.e_shop_data_entry.edit_product', [
            'newId' => $newId,
            'product' => $product,
            'list_product' => $listProduct,
            'prodCat' => $prodCat,
            'brands' => $brand,
            'categories' => $category,
            'productDiscount' => $productDiscount,
            'alias' => $alias,
            'images' => $image
        ]);
    }

    public function update(Request $request, $id)
    {
        //optimize image
        list($pathCache, $filename) = $this->getPathImage();
        //update product
        $prodUpdate = $request->only(
            'name',
            'title',
            'price',
            'brand_id',
            'meta_description',
            'keywords',
            'description',
            'status'
        );
        $product = Product::find($id);
        $product->update($prodUpdate);
        $product->save();
        //update product_categories
        $catId = $request->only('category_id')['category_id'];
        $prodCatOld = ProductCategory::where('product_id', $id)->get();
        if (count($prodCatOld) > 0) {
            foreach ($prodCatOld as $catOld) {
                $arrHasKey = array_keys($catId, $catOld['category_id']);
                if (count($arrHasKey) > 0) {
                    foreach ($arrHasKey as $key) {
                        unset($catId[$key]);
                    }
                } else {
                    ProductCategory::where(['category_id' => $catOld['category_id'], 'product_id' => $id])->delete();
                    foreach ($catId as $ci) {
                        $where['category_id'] = $ci;
                        $where['product_id'] = $id;
                        ProductCategory::firstOrCreate($where);
                        unset($ci);
                    }
                }
            }
            if (count($catId) > 0) {
                foreach ($catId as $ci) {
                    ProductCategory::firstOrCreate(['product_id' => $id, 'category_id' => $ci]);
                }
            }
        } else {
            foreach ($catId as $ci) {
                ProductCategory::firstOrCreate(['product_id' => $id, 'category_id' => $ci]);
            }
        }
        //update list product
        $this->optimizeImage($pathCache);
        $prodListUpdate = $request->only(
            'name',
            'price',
            'brand_id',
            'status'
        );
        $prodListUpdate['image'] = $filename;
        $prodList = ListProduct::find($id);
        $prodList->update($prodListUpdate);
        $prodList->save();
        //update в product_image
        $prodImgOld = ProductImage::where('product_id', $id)->get();
        $imageAr = $_POST['filepath'];
        foreach ($imageAr as $i => $img) {
            if (mb_strlen($img) > 0) {
                if(mb_strpos($img, 'http') === 0 || mb_strpos($img, 'http') > 0){
                    $img = explode('image/', $img)[1];
                }
            } else {
                break;
            }
            $action = '';
            foreach ($prodImgOld as $valKey => $prImOl) {

                if ($prImOl->image == $img) {
                    $action = 'stop';
                    unset($prodImgOld[$valKey]);
                    unset($imageAr[$i]);
                    break;
                } else $action = null;
            }
            if ($action !== 'stop') {
                $prodImageCreate = new ProductImage();
                $prodImageCreate->product_id = $id;
                $prodImageCreate->sort = $i;
                $prodImageCreate->image = $img;
                $prodImageCreate->id = (DB::table('product_image')->max('id') + 1);
                $prodImageCreate->save();
            }
        }
        if (count($prodImgOld) > 0) {
            foreach ($prodImgOld as $keypio => $prImOl) {
                $keyArr = array_keys($imageAr, $prImOl->image);
                if (count($keyArr) === 0 || $prImOl->image == '') {
                    //delete entry into the product_option and the product_option_value
                    $prodImgDel = ProductImage::find($prImOl->id);
                    $prodImgDel->delete();
                }
            }
        }
        //update alias
        AliasProduct::where('id', $id)->update(['alias' => $_POST['alias']]);
        //update product_discount
        $prodDiscUpdate = $request->only('discount', 'date_end', 'date_start');
        if (mb_strlen($prodDiscUpdate['date_start']) === 0) {
            $prodDiscUpdate['date_start'] = date('Y-m-d');
            $prodDiscUpdate['product_id'] = $id;
        }
        $productDiscount = ProductDiscount::where('product_id', $id)->get();
        if (mb_strlen($prodDiscUpdate['discount']) > 0 && mb_strlen($prodDiscUpdate['date_end']) > 0) {
            if (mb_strlen($prodDiscUpdate['date_end']) === 0) $prodDiscUpdate['date_start'] = date('Y-m-d');
            if (count($productDiscount) == 1)
                DB::table('product_discounts')->where('product_id', $id)->update($prodDiscUpdate);
            else ProductDiscount::firstOrCreate($prodDiscUpdate);
        } else {
            if (count($productDiscount) > 0) ProductDiscount::where('product_id', $id)->delete();
        }
        return back()->with('message', 'Product update');
    }

    public function editProductOptions($id)
    {
        \Session::put('message', 'Product update');
        $idArr = explode('new', $id);

        if (count($idArr) > 1) {
            $product = new Product();
            $product->id = $idArr[1];
            $id = $idArr[0];
            \Session::put('message', 'Product create');
        } else $product = Product::find($id);
        $productOptionValue = ProductOptionValue::with('product_option')->where('product_id', $id)->get();

        if(count($productOptionValue) === 0){
            $option = DB::table('option')
                ->select('id', 'name')
                ->get();
            $value = DB::table('value')
                ->select('id', 'name')
                ->where('option_id', '=', $option[0]->id)
                ->get();
            return view('admin.e_shop_data_entry.create_product_options', [
                'options' => $option,
                'values' => $value,
                'idProduct' => $product->id
            ]);
        } else {
            $option = DB::table('option')
                ->select('option.id', 'option.name')
                ->get();
            return view('admin.e_shop_data_entry.edit_product_options', [
                'productOptionValues' => $productOptionValue,
                'options' => $option,
                'product' => $product
            ]);
        }
    }

    public function updateProductOptions(Request $request, $id)
    {
        //delete product_option and product_option_value
        ProductOption::where('product_id', $id)->delete();
        ProductOptionValue::where('product_id', $id)->delete();
        //update product_option and product_option_value
        $_POST['product_id'] = $id;
        //dump($_POST);
        $this->saveOptionValue();
        return back()->with('message', 'Product options update');
    }

    public function destroy(Request $request)
    {
        $id = $request->only('id')['id'];
        ListProduct::destroy($id);
        ProductCategory::where('product_id', $id)->delete();
        ProductOption::where('product_id', $id)->delete();
        ProductOptionValue::where('product_id', $id)->delete();
        ProductImage::where('product_id', $id)->delete();
        ProductDiscount::where('product_id', $id)->delete();
        AliasProduct::destroy($id);
        $product = Product::find($id);
        $product->delete();

        return 'Remove';
    }

    /**
     * @param Request $request
     */
    public function saveOptionValue()
    {
        //dd($_POST);
        //save into product_option
        $count = 0;
        foreach ($_POST as $key => $val) {
            if (strpos($key, 'option') === 0) {
                $numberKeyOption[$count++] = (int)explode('_', $key)[1];

            }
        }
        for ($i = 0; $i < $count; $i++) {
            $key = $numberKeyOption[$i];
            $where = [];
            $where['product_id'] = (int)$_POST['product_id'];
            $where['option_id'] = (int)$_POST['option_' . $key];
            $where['required'] = 1;
            /*$where['option_value'] = '';
            if (array_key_exists('require_option_' . $key, $_POST) && $_POST['require_option_' . $key] == 'on') $where ['required'] = 1;
            else $where ['required'] = 0;*/
            $productOption = ProductOption::where($where)->get();
            if (count($productOption) === 0) {
                $where['id'] = (DB::table('product_option')->max('id') + 1);
                $productOption = ProductOption::create($where);
                $idProdOpt = $productOption->id;
            } else {
                $idProdOpt = $productOption[0]->id;
            }
            //save into product_option_value
            $idProdOptVal = DB::table('product_option_value')->max('id');
            $productOptionValue = new ProductOptionValue;
            $productOptionValue->id = $idProdOptVal + 1;
            $productOptionValue->product_id = (int)$_POST['product_id'];
            $productOptionValue->option_id = (int)$_POST['option_' . $key];
            $productOptionValue->value_id = (int)$_POST['value_' . $key];
            $productOptionValue->product_option_id = $idProdOpt;
            if ($_POST['price_option_' . $key] == '') $_POST['price_option_' . $key] = 0;
            $productOptionValue->price = $_POST['price_option_' . $key];
            $productOptionValue->save();
        }
    }

    public function searchProduct()
    {
        $listProduct = DB::select('SELECT
                  list_products.id,
                  list_products.name,
                  list_products.price,
                  list_products.status,
                  products.title
                FROM products
                  INNER JOIN list_products
                    ON products.id = list_products.id
                WHERE list_products.name LIKE \'%' . $_GET['product'] . '%\'');
        $page = null;
        $perPage = 20;
        $option = [];
        $page = $page ?: (LengthAwarePaginator::resolveCurrentPage() ?: 1);
        $listProduct = $listProduct instanceof Collection ? $listProduct : Collection::make($listProduct);
        $paginate = new LengthAwarePaginator($listProduct->forPage($page, $perPage), $listProduct->count(), $perPage, $page, $option);
        //$paginate->setPath('rasprodaga');
        if (count($listProduct) > 0) {
            return view('admin.e_shop_data_entry.products', ['products' => $paginate]);
        } else return back()->with('message', 'Product doesn\'t find');

    }

    /**
     * @return array
     */
    public function getPathImage()
    {
        $basePath = base_path() . '/image/';
        $pathAr = explode('image', $_POST['filepath'][0]);
        if (count($pathAr) > 1) $path = $basePath . $pathAr[1];
        else $path = $basePath . $pathAr[0];
        $filename = explode('/', $path);
        $filename = array_pop($filename);
        $pathCache = $basePath . 'cache/' . $filename;
        copy($path, $pathCache);
        return array($pathCache, $filename);
    }
    public function optimizeImage($pathCache){
        $info = getimagesize($pathCache);
        $height = $info[1];
        $widht = $info[0];
        $ratio = $height / 280;
        $newWidth = $widht / $ratio;
        $imageOptimize = new ImageOptimizeController();
        $imageOptimize->resizeImage($pathCache, $newWidth, 280, $info);
        $imageOptimize->optimizeImage($pathCache);
    }
}
