<?php

namespace App\Http\Controllers\FrontendDataEntry;

use App\ListBrand;
use Illuminate\Http\Request;

//use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Brand;
use DB;
use App\AliasBrand;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brand = Brand::paginate(25);
        return view('admin.frontend_data_entry.brands', ['brands' => $brand]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listBrand = DB::table('list_brands')
            ->select('id')
            ->get();
        foreach($listBrand as $entry){
            $idBrands[] = $entry->id;
        }
        $brand = DB::table('brands')
            ->whereNotIn('id', $idBrands)
            ->select('id', 'name')
            ->get();

        return view('admin.frontend_data_entry.create_brand', ['brands' => $brand]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Brand::create($request->except('_token'));
        return back()->with('message','Brand created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = Brand::find($id);
        $listBrand = ListBrand::all();
        $alias = AliasBrand::find($id);
        /*echo '<pre>';
        print_r($listBrand[12]);
        echo '</pre>';
        die;*/
        return view('admin.frontend_data_entry.edit_brand', ['listBrand' => $listBrand, 'brand' => $brand, 'alias' => $alias]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $brand = Brand::find($id);
        $brand->update($request->only('name', 'title', 'meta_description', 'keywords', 'content', 'user_id'));
        $brand->save();
        $alias = AliasBrand::find($id);
        $alias->update($request->only('alias'));
        $alias->save();
        return back()->with('message', 'Brand update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);
        $brand->delete();
        return $brand->name;
    }
}
