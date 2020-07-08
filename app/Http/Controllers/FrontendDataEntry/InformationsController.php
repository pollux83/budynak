<?php

namespace App\Http\Controllers\FrontendDataEntry;

use App\AliasInformation;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Information;
use DB;

class InformationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info = Information::paginate(25);
        return view('admin.frontend_data_entry.informations', ['informations' => $info]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.frontend_data_entry.create_information');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $where = $request->only('title', 'name', 'meta_description', 'keywords', 'content', 'user_id', 'status', 'sort');
        $result = Information::firstOrCreate($where);
        $entryArr = $request->only('alias');
        $entryArr['id'] = $result->id;
        AliasInformation::create($entryArr);
        return back()->with('message','Information created');
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
        $info = Information::find($id);
        $aliasInfo = AliasInformation::where('id', $id)->get();
        return view('admin.frontend_data_entry.edit_information', ['info' => $info, 'alias' => $aliasInfo]);
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
        $info = Information::find($id);
        $info->update($request->only('title', 'name', 'meta_description', 'keywords', 'content', 'user_id', 'status', 'sort'));
        $info->save();
        $aliasInfo = AliasInformation::find($id);
        $aliasInfo->alias = $request->only('alias')['alias'];
        $aliasInfo->save();
        return back()->with('message', 'Information update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $info = Information::find($id);
        $info->delete();
        AliasInformation::where('id', $id)->delete();
        return $info->name; // метод возвратит название удаленной категории, которую мы отобразим в окне alert
    }
}
