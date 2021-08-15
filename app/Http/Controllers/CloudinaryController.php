<?php

namespace App\Http\Controllers;

use JD\Cloudder\CloudinaryWrapper;
use JD\Cloudder\Facades\Cloudder;

use Illuminate\Http\Request;


class CloudinaryController extends Controller
{

    public function test(){
        $api = resolve('cloudder');
        dd($api);
        //$api = new CloudinaryWrapper('','','','');
        //$api = $api->getApi();

       // dd($api);

       // return view('cloudinary');
    }

    public function uploadImages(Request $request)

    {

        $this->validate($request,[

            'image_name'=>'required|mimes:jpeg,bmp,jpg,png|between:1, 6000',

        ]);

        $image_name = $request->file('image_name')->getRealPath();

        Cloudder::upload($image_name, null);

        return redirect()->back()->with('status', 'Image Uploaded Successfully');

    }

}
