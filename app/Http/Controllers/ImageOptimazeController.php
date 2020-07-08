<?php

namespace App\Http\Controllers;

use App\Category;
use App\ListProduct;
use Illuminate\Http\Request;

class ImageOptimazeController extends Controller
{
    public function run(){
        $this->getCacheImage('/products');
        $this->getCacheImage('/categories');
        return back()->with(['message' => 'Images optimazed']);
    }

    public function getCacheImage($cacheCategory){
        if($cacheCategory == '/products') $imageDB = ListProduct::select('id', 'image')->get();
        elseif($cacheCategory == '/categories') $imageDB = Category::select('id', 'image')->get();

        foreach($imageDB as $iDB){
            if(strpos($iDB->image, 'http') === 0) {
                $iDB->image = explode('image/', $iDB->image)[1];
            }
            if(strpos($iDB->image, '%20') >= 0) str_replace('%20', ' ', $iDB->image);
            //$exp = explode('/', $iDB->image);
            //$nameImg = array_pop($exp);
            $path = base_path().'/image/'. $iDB->image;
            //$newPath = storage_path('image'. $cacheCategory .'/') . $nameImg;
            $result = $this->optimazeImage($path);
            if(!$result) continue;
        }

    }

    public function optimazeImage($path){
        if(!is_file($path)) return ;
        ini_set('gd.jpeg_ignore_warning', true);
        //$quality :: 0 - 100
        $info = getimagesize($path);
        $quality = 50;
        if ($info['mime'] == 'image/jpeg')
        {
            $image = @imagecreatefromjpeg($path);
            //save file
            imagejpeg($image, $path, $quality);//ranges from 0 (worst quality, smaller file) to 100 (best quality, biggest file). The default is the default IJG quality value (about 75).
            //Free up memory
            imagedestroy($image);
        }
        elseif ($info['mime'] == 'image/png')
        {
            $image = @imagecreatefrompng($path);

            imageAlphaBlending($image, true);
            imageSaveAlpha($image, true);

            /* chang to png qulity */
            $png_quality = 9 - (($quality * 9 ) / 100 );
            imagePng($image, $path, $png_quality);//Compression level: from 0 (no compression) to 9.
            //Free up memory
            imagedestroy($image);
        }
    }
}
