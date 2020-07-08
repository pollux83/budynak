<?php

namespace App\Http\Controllers\FrontendDataEntry;

use DB;
use App\Category;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Collection;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Page;
use App\AliasCategory;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::paginate(25);
        return view('admin.frontend_data_entry.pages', ['pages' => $pages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $page = DB::table('pages')
        ->select('id')
        ->get();
        foreach($page as $entry){
            $idPages[] = $entry->id;
        }
        $category = DB::table('categories')
            ->whereNotIn('id', $idPages)
            ->select('categories.id', 'categories.name')
            ->get();

        return view('admin.frontend_data_entry.create_page', ['categories' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Page::create($request->except('_token'));
        return back()->with('message','Page created');
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
        $category = Category::all(['id', 'name']);
        $page = Page::find($id);
        $alias = AliasCategory::find($id);
        return view('admin.frontend_data_entry.edit_page', ['page' => $page, 'categories' => $category, 'alias' => $alias]);
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
        $page = Page::find($id);
        $page->update($request->only('name', 'title', 'keywords', 'meta_description', 'content', 'user_id'));
        $page->save();
        $alias = AliasCategory::find($id);
        $alias->update($request->only('alias'));
        $alias->save();
        return back()->with('message', 'Page update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::find($id);
        $page->delete();
        return 'Remove'; // метод возвратит название удаленной категории, которую мы отобразим в окне alert
    }
}
