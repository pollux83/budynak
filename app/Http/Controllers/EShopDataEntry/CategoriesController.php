<?php

namespace App\Http\Controllers\EShopDataEntry;



use App\AliasProduct;
use App\ListProduct;
use App\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\ImageOptimazeController;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Category;
use App\Menu;
use App\AliasCategory;
use App\Product;
use App\ProductCategory;
use App\ProductImage;
use App\ProductOption;
use App\ProductOptionValue;



class CategoriesController extends Controller
{
    private $category;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = DB::table('categories')
            ->whereNull('category')
            ->orWhere(function($query) {
                $query->whereColumn('category', 'id');
            })
            ->select('name', 'image', 'id', 'sort', 'category', 'status', 'brand')
            ->orderBy('sort')
            ->paginate(25);
        $unit = DB::select('SELECT categories.name, categories.id 
                            FROM categories
                            WHERE categories.category = categories.id
                            ORDER BY categories.sort');
        return view('admin.e_shop_data_entry.categories', ['categories' => $category, 'units' => $unit]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allCategories = DB::table('categories')->select('id', 'name', 'sort')->where('status', 1)->get();
        $idCategory = (DB::table('categories')->max('id'))+1;
        $menu = Menu::all('name', 'id');
        return view('admin.e_shop_data_entry.create_category',[
            'allCategories' => $allCategories,
            'idCategory' => $idCategory,
            'menus' => $menu
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->getPostImgAndNullMenu();

        $category = new Category;
        $category->id = $_POST['id'];
        $category->name = $_POST['name'];
        $category->category = $_POST['category'];
        $category->menu = $_POST['menu'];
        $category->sort = $_POST['sort'];
        $category->status = $_POST['status'];
        $category->image = $_POST['image'];
        $category->brand = $_POST['brand'];
        $category->save();

        $insert = array(
            'alias' => $_POST['alias'],
            'id' => $_POST['id']
        );

        AliasCategory::create($insert);
        Controller::getSession();//list of a categories for the submenu for products and categories
        return back()->with('message','Category created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categories = DB::select('SELECT categories.name, categories.image, categories.id, categories.sort, categories.category, categories.status, categories.brand 
                            FROM categories
                            WHERE categories.category <> categories.id
                            AND categories.id <> ?
                            AND categories.category = ? 
                            ORDER BY categories.sort', [$id, $id]);

        $unit = DB::select('SELECT categories.name, categories.id 
                            FROM categories
                            WHERE categories.category = ?', [$id]);
        if(count($categories) > 0){
            foreach ($categories as $val) {
                $this->category[] = $val;
                $this->getSubcategories($val);
            }
        }
        if(count($this->category) == 0){
            $this->category = $categories;
        }
        ////////create paginate
        $page = null;
        $perPage = 20;
        $option = [];
        $page = $page ?: (LengthAwarePaginator::resolveCurrentPage() ?: 1);
        $this->category = $this->category instanceof Collection ? $this->category : Collection::make($this->category);
        $paginate = new LengthAwarePaginator($this->category->forPage($page, $perPage), $this->category->count(), $perPage, $page, $option);
        $paginate->setPath('');

        return view('admin.e_shop_data_entry.categories', ['categories' => $paginate, 'units' => $unit]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        $allCategories = DB::table('categories')->select('id', 'name', 'sort')->get();
        $menu = Menu::all();
        $uri = DB::table('aliases_categories')->select('alias')->where(['id' => $id]) ->get();
        return view('admin.e_shop_data_entry.edit_category', [
            'category' => $category,
            'allCategories' => $allCategories,
            'menus' => $menu,
            'uri' => $uri
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $this->getPostImgAndNullMenu();

        $row = [
            'id' => $_POST['id']
        ];
        AliasCategory::where($row)->update(['alias' => $_POST['alias']]);
        unset($_POST['alias']);

        $category = Category::find($id);
        $category->update($_POST);
        $category->save();
        Controller::getSession();//list of a categories for the submenu for a products
        return back()->with('message', 'Category update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->only('id')['id'];
        $subCat = Category::where('category', '=', $id)->count();

        if(count($subCat) > 1){
            return 'The category has the subcategories';
        } else {
            $prodId = DB::select('SELECT
                  product_categories.product_id AS id
                FROM product_categories
                WHERE product_categories.category_id = ?', [$id]);
            foreach($prodId as $pi){
                ProductOptionValue::where('product_id', '=', $pi->id)->delete();
                ProductOption::where('product_id', '=', $pi->id)->delete();
                ProductImage::where('product_id', '=', $pi->id)->delete();
                Product::destroy($pi->id);
                ListProduct::destroy($pi->id);
                AliasProduct::destroy($pi->id);
                ProductCategory::where('product_id', '=', $pi->id)->delete();
            }
            $page = Page::find($id);
            if(isset($page)){
                Page::destroy($id);
            }
            Category::find($id)->delete();
            AliasCategory::where(['id' => $id])->delete();
            Controller::getSession();//list of a categories for the submenu for a products
            return 'Remove';
        }
    }

    public function getPostImgAndNullMenu()
    {
        if($_POST['menu'] == 'null'){
            $_POST['menu'] = null;
        }
        if (array_key_exists('image', $_POST)) {
            if (mb_strpos($_POST['image'], 'http') === 0 || mb_strpos($_POST['image'], 'http') > 0) {
                $_POST['image'] = explode('image/', $_POST['image'])[1];
                /*$imageOptimaze = new ImageOptimazeController();
                $path = base_path().'/image/'. $_POST['image'];
                $imageOptimaze->optimazeImage($path);*/
            }
        }
    }

    public function getSubcategories($val)
    {
        $subcategories = DB::select('SELECT categories.name, categories.image, categories.id, categories.sort, categories.category, categories.status, categories.brand 
                            FROM categories
                            WHERE categories.category <> categories.id
                            AND categories.id <> ?
                            AND categories.category = ? 
                            ORDER BY categories.sort', [$val->id, $val->id]);
        if(count($subcategories) > 0){
            foreach ($subcategories as $cat) {
                $this->category[] = $cat;
                //check on isset subcategories
                $subcategories2 = DB::select('SELECT categories.name, categories.image, categories.id, categories.sort, categories.category, categories.status, categories.brand 
                            FROM categories
                            WHERE categories.category <> categories.id
                            AND categories.id <> ?
                            AND categories.category = ? 
                            ORDER BY categories.sort', [$cat->id, $cat->id]);
                $countSubCat = count($subcategories2);
                if ($countSubCat > 0) {
                    $this->getSubcategories($cat);
                }
            }
        }
    }
}
