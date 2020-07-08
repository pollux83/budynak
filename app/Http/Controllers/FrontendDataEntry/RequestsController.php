<?php

namespace App\Http\Controllers\FrontendDataEntry;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\RequestCustomer;

class RequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requests = RequestCustomer::all();
        return view('admin.frontend_data_entry.requests', ['requests' => $requests]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $postAr = $request->except('_token');
        foreach($postAr as $key => $post){
            $post = trim($post);
            $post = stripslashes($post);
            $post = htmlspecialchars($post);
            $postAr[$key] = $post;
        }
        $model = new RequestCustomer();
        foreach($postAr as $key => $post){
            $model->$key = $post[$key];        
        }
        $model->save();
        //DB::table('requests')->insert($postAr);
        
        //RequestCustomer::create($postAr);
        return back()->with('message','Ваше письмо получено');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $request = RequestCustomer::find($id);
        return view('admin.frontend_data_entry.edit_request', ['request' => $request]);
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
        $requests = RequestCustomer::find($id);
        $requests->update($request->all());
        $requests->save();
        return back()->with('message', 'Request update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $request = RequestCustomer::find($id);
        $request->delete();
        return $request->name;
    }
}
