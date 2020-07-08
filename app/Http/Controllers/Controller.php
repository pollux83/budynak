<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getSession()
    {
        $categories = DB::select('SELECT categories.name, categories.id FROM categories
                            WHERE categories.category = categories.id
                            ORDER BY categories.sort');
        if (count($categories) > 0) {
            foreach($categories as $category){
                $subcat = DB::select('SELECT categories.name, categories.id FROM categories
                            WHERE categories.category <> categories.id
                            AND categories.category = ?
                            ORDER BY categories.sort', [$category->id]);
                if(count($subcat) > 0){
                    $catArr[] = $category;
                }
            }
        }
        session_start();
        $base_url = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
        $_SESSION['base_url'] = $base_url;
        $_SESSION['cat'] = $catArr;
    }
}
