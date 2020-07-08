<?php

namespace App\Http\Controllers\Seo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\ListProduct;
use File;
use Illuminate\Support\Facades\DB;


class ImageOptimizeController extends Controller
{
    private $pathImage;

    public function __construct()
    {
        ini_set('gd.jpeg_ignore_warning', true);
        $this->pathImage = base_path() . '/image/';
    }

    public function getInfoImageCat()
    {
        /*$pages = [];
        $categories = Category::where(['status' => 1])->get();
        foreach ($categories as $category) {
            $path = $this->pathImage . $category->image;
            if (is_file($path)) {
                $info = getimagesize($path);
                $height = $info[1];
                if ($height >= 187 && $height <= 189) {
                    $category->size = $info[3];
                    $category->weight = filesize($path);
                    $this->resizeImage($path, 319, 188, $info);
                }
                if (filesize($path) > 40000) $this->optimizeImage($path);
            } else {
                $category->size = '-';
                $category->weight = '-';
                $pages[] = $category;
            }
        }
        $ths = ['ID', 'Name', 'Image', 'Size', 'Weight'];

        return view('admin.seo.form', ['pages' => $pages, 'keysDouble' => '', 'ths' => $ths]);*/
    }

    public function getInfoImageProd()
    {
        $directories = scandir($this->pathImage);
        $hasDir = array_search('cache', $directories);
        if (!$hasDir) mkdir($this->pathImage . 'cache');
        $pages = [];
        $products = ListProduct::where(['status' => 1])->get();
        foreach ($products as $product) {
            if (!$product->image) {
                $product->error = 'not image';
                $pages[] = $product;
                continue;
            }
            $image = $product->image;
            $checkImage = explode('http', $image);
            $update = FALSE;
            if (count($checkImage) > 1) {
                $image = explode('image/', $image)[1];
                $update = TRUE;
            }
            $checkImage = explode('/', $image);
            if (count($checkImage) > 1) {
                $filename = array_pop($checkImage);
                $update = TRUE;
            } else $filename = $checkImage[0];
            if ($update) ListProduct::where('id', $product->id)->update(['image' => $filename]);
            $path = $this->pathImage . $image;
            $pathCache = $this->pathImage . 'cache/' . $filename;
            if (!is_file($pathCache)) {
                copy($path, $pathCache);
            }
            $info = getimagesize($pathCache);
            $height = $info[1];
            $widht = $info[0];
            $product->size = $info[3];
            $ratio = $height / 280;
            $newWidth = $widht / $ratio;
            $product->weight = filesize($pathCache);
            if ($ratio <= 0.99 || $ratio >= 1.1) {
                $product->error = 'Size was mistaken';
                $this->resizeImage($pathCache, $newWidth, 280, $info);
                $pages[] = $product;
            }
            /*if (is_file($pathCache) && filesize($pathCache) > 60000) {
                $this->optimizeImage($pathCache, $product->weight);
                $product->error = 'big size';
                $pages[] = $product;
            }*/
        }

        $ths = ['ID', 'Name', 'Image', 'Size', 'Weight', 'Error'];

        return view('admin.seo.form', ['pages' => $pages, 'keysDouble' => '', 'ths' => $ths]);
    }

    public function run()
    {
        //$this->getCacheImage('/products');
        $this->getCacheImage('/categories');
        return back()->with(['message' => 'Images optimized']);
    }

    public function getCacheImage($cacheCategory)
    {
        /*if ($cacheCategory == '/products') $imageDB = ListProduct::select('id', 'image')->get();
        elseif ($cacheCategory == '/categories') $imageDB = Category::select('id', 'image')->get();

        foreach ($imageDB as $iDB) {
            if (strpos($iDB->image, 'http') === 0) {
                $iDB->image = explode('image/', $iDB->image)[1];
            }
            if (strpos($iDB->image, '%20') >= 0) str_replace('%20', ' ', $iDB->image);
            //$exp = explode('/', $iDB->image);
            //$nameImg = array_pop($exp);
            $path = $this->pathImage . $iDB->image;
            //$newPath = storage_path('image'. $cacheCategory .'/') . $nameImg;
            $result = $this->optimizeImage($path);
            if (!$result) continue;
        }*/
    }

    public function optimizeImage($path, $size = FALSE)
    {
        if (!is_file($path)) return;
        //$quality :: 0 - 100
        $info = getimagesize($path);

        /*if($size) {
            $size = $size / 1000;
            $quality = (($size / pow($size, 1/5)) *100) / $size;
        } else $quality = 80;*/

        $quality = 80;

        if ($info['mime'] == 'image/jpeg') {
            $image = @imagecreatefromjpeg($path);
            //save file
            imagejpeg($image, $path, $quality);//ranges from 0 (worst quality, smaller file) to 100 (best quality, biggest file). The default is the default IJG quality value (about 75).
            //Free up memory
            imagedestroy($image);
        } elseif ($info['mime'] == 'image/png') {
            $image = @imagecreatefrompng($path);

            imageAlphaBlending($image, true);
            imageSaveAlpha($image, true);

            /* chang to png quality */
            $png_quality = 9 - (($quality * 9) / 100);
            imagePng($image, $path, $png_quality);//Compression level: from 0 (no compression) to 9.
            //Free up memory
            imagedestroy($image);
        }
    }

    public function resizeImage($file, $w, $h, $info, $crop = FALSE)
    {
        list($width, $height) = $info;
        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width - ($width * abs($r - $w / $h)));
            } else {
                $height = ceil($height - ($height * abs($r - $w / $h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w / $h > $r) {
                $newwidth = $h * $r;
                $newheight = $h;
            } else {
                $newheight = $w / $r;
                $newwidth = $w;
            }
        }

        if ($info['mime'] == 'image/jpeg') {
            $src = @imagecreatefromjpeg($file);
            $dst = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            //save file
            imagejpeg($dst, $file, 100);//ranges from 0 (worst quality, smaller file) to 100 (best quality, biggest file). The default is the default IJG quality value (about 75).
            //Free up memory
            imagedestroy($dst);
        } elseif ($info['mime'] == 'image/png') {
            $src = @imagecreatefrompng($file);
            $dst = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            //save file
            imagePng($dst, $file, 9);//Compression level: from 0 (no compression) to 9.
            //Free up memory
            imagedestroy($dst);
        }
    }
}
