<?php

namespace App\Http\Controllers\EShopDataEntry;

use App\OptionValue;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Value;
use Illuminate\Support\Facades\DB;

class ValuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $value = Value::with('option')->paginate(20);
        return view('admin.e_shop_data_entry.values', ['value' => $value]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $option = DB::table('option')
            ->select('id', 'name')
            ->get();
        return view('admin.e_shop_data_entry.create_value')->with('options', $option);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $viewNew = $request->only('name', 'option_id');
        $valueCreated = Value::create($viewNew);
        $image = $_POST['image'];
        if(mb_strpos($image, 'http') === 0) {
            $image = explode('image/', $image)[1];
        }
        $optionValueNew = $request->only('option_id', 'sort_order');
        $optionValueNew['value_id'] = $valueCreated->id;
        $optionValueNew['image'] = $image;
        OptionValue::create($optionValueNew);
        return back()->with('message','Value created');
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
        $value = Value::with('option')->where('id','=', $id)->get();
        $option = DB::table('option')
            ->select('id', 'name')
            ->get();
        $valueOption = OptionValue::where('value_id', $id)->get();
        return view('admin.e_shop_data_entry.edit_value', [
            'options' => $option,
            'value' => $value,
            'valueOption' => $valueOption
        ]);
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
        $viewUpdate = $request->only('name', 'option_id');
        $value = Value::find($id);
        $value->update($viewUpdate);
        $value->save();
        $image = $_POST['image'];
        if(mb_strpos($image, 'http') === 0) {
            $image = explode('image/', $image)[1];
        }
        $optionValueUpdate = $request->only('option_id', 'sort_order');
        $optionValueUpdate['image'] = $image;
        OptionValue::where(['value_id' => $id])->update($optionValueUpdate);
        return back()->with('message', 'Value update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Value::find($request->only('id')['id'])->delete();
        OptionValue::where(['value_id' =>$request->only('id')['id']])->delete();
        return 'Remove';
    }
}
