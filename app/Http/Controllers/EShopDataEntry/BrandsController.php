<?php

namespace App\Http\Controllers\EShopDataEntry;

use App\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ListBrand;
use App\Brand;
use Illuminate\Support\Facades\DB;
use App\Product;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$brand = DB::select('SELECT
                  categories.name,
                  categories.id,
                  categories.sort,
                  aliases_categories.alias,
                  aliases_categories_1.alias AS par_al
                FROM aliases_categories
                  INNER JOIN categories
                    ON aliases_categories.id = categories.id
                  INNER JOIN aliases_categories aliases_categories_1
                    ON categories.category = aliases_categories_1.id
                WHERE categories.status = 1
                AND categories.brand = 1
                ORDER BY categories.sort DESC');*/
        $brand = Category::where('brand', 1)->paginate(20);
        return view('admin.e_shop_data_entry.list_brands', ['brands' => $brand]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.e_shop_data_entry.create_list_brand');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        if(array_key_exists('filepath_0', $data)){
            $data['image'] = $data['filepath_0'];
            unset($data['filepath_0']);
        }
        $exp = explode('/', $_POST['filepath_0']);
        if (count($exp) > 4) {
            foreach ($exp as $id => $val) {
                if ($val !== 'data') {
                    unset($exp[$id]);
                } else {
                    break;
                }
            }
            $data['image'] = implode('/', $exp);
        }
        ListBrand::create($data);
        return back()->with('message','Brand created');
    }
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = ListBrand::find($id);
        return view('admin.e_shop_data_entry.edit_list_brand', ['brand' => $brand]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $entryUpd = $request->except('_method', '_token');
        $entryUpd['image'] = $entryUpd['filepath_0'];
        unset($entryUpd['filepath_0']);
        $brand = ListBrand::find($id);
        $brand->update($entryUpd);
        $brand->save();
        return back()->with('message', 'Brand update');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->only('id')['id'];
        $products = Product::where('brand_id', $id)->count();
        if($products > 0){
            return 'Brand has the products';
        } else {
            $brand = Brand::find($id);
            if(isset($brand)){
                Brand::destroy($id);
            }
            ListBrand::find($id)->delete();
            return 'Remove';
        }
    }

    public function changeSortBrandAjax($id){
        if (array_key_exists('brand_sort', $_POST)) {
            $brand_sort = (int)$_POST['brand_sort'];
            $result = DB::table('categories')->where('id', $id)->update(['brand_sort' => $brand_sort]);
            if (!$result) {
                return false;
            }
            return 'true';
        } else return false;
    }
}
