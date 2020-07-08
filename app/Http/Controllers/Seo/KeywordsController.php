<?php

namespace App\Http\Controllers\Seo;

use App\AliasCategory;
use App\AliasProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Page;
use DB;
use PhpParser\Node\Stmt\TraitUseAdaptation\Alias;

class KeywordsController extends Controller
{
    private $keys = [];

    public function getKeys()
    {
        $pages = DB::select('SELECT
              pages.id,
              pages.keywords,
              pages.name
            FROM categories
              INNER JOIN pages
                ON categories.id = pages.id
            WHERE categories.status = 1');

        $keys = '';
        foreach ($pages as $page) {
            $keys .= $page->keywords;
        }
        $keys = explode(',', $keys);
        $keysDouble = $this->findDouble($keys);

        $ths = ['ID', 'Name', 'Keywords'];

        return view('admin.seo.form', ['pages' => $pages, 'keysDouble' => $keysDouble, 'ths' => $ths]);
    }

    public function getUrl()
    {
        $aliases = AliasProduct::all();
        $class = 'prod';
        $wherein = $this->findErrorUrl($aliases, $class);
        $urlsDouble = $this->findDouble($this->keys);
        $wherein1 = explode(', ', $urlsDouble);
        $wherein = array_merge($wherein, $wherein1);
        $aliases1 = DB::table('products')
            ->join('aliases_products', 'aliases_products.id', '=', 'products.id')
            ->whereIn('aliases_products.alias', $wherein)
            ->select('aliases_products.id', 'aliases_products.alias', 'products.name')
            ->orderBy('alias')
            ->get()->toArray();

        $aliasesCat = AliasCategory::all();
        $this->keys = [];
        $class = 'cat';
        $wherein = $this->findErrorUrl($aliasesCat, $class);
        $urlsDouble = $this->findDouble($this->keys);
        $wherein1 = explode(', ', $urlsDouble);
        $wherein = array_merge($wherein, $wherein1);
        $aliases2 = DB::table('categories')
            ->join('aliases_categories', 'aliases_categories.id', '=', 'categories.id')
            ->whereIn('aliases_categories.alias', $wherein)
            ->select('aliases_categories.id', 'aliases_categories.alias', 'categories.name')
            ->orderBy('alias')
            ->get()->toArray();

        $aliases = array_merge($aliases1, $aliases2);

        $ths = ['ID', 'Name', 'Alias'];

        return view('admin.seo.form', ['pages' => $aliases, 'keysDouble' => $urlsDouble, 'ths' => $ths]);
    }

    private function findErrorUrl($aliases, $class){
        $wherein = [];
        foreach ($aliases as $alias) {
            $al = $alias->alias;
            $id = $alias->id;
            $this->keys[] = $al;
            if(preg_match('/[A-Z]/',$al)) {
                $alias = strtolower($al);
                $this->updateAlias($class, $alias, $id);
                $wherein[] = $al;
            }
            if(preg_match('/ /',$al)){
                $al = trim($al);
                $alias = preg_replace('/(  | )/', '-', $al);
                $this->updateAlias($class, $alias, $id);
                $wherein[] = $al;
            }
            if(preg_match('/_/',$al)){
                $alias = preg_replace('/_/', '-', $al);
                $this->updateAlias($class, $alias, $id);
                $wherein[] = $al;
            }
            if(preg_match('/--/',$al)){
                $alias = preg_replace('/--/', '-', $al);
                $this->updateAlias($class, $alias, $id);
                $wherein[] = $al;
            }
            if(preg_match('/[А-Яа-я]/', $al)) $wherein[] = $al;
        }
        return $wherein;
    }

    private function updateAlias($class, $alias, $id){
        if($class == 'prod') AliasProduct::where('id', $id)->update(['alias' => $alias]);
        elseif($class == 'cat') AliasCategory::where('id', $id)->update(['alias' => $alias]);
    }

    private function findDouble($keys)
    {
        foreach ($keys as $key) {
            $uniqueKeys[$key] = '';
        }
        $uniqueKeys = array_keys($uniqueKeys);
        $doubles = count($keys) - count($uniqueKeys);
        if ($doubles > 0) {
            foreach ($uniqueKeys as $uniqueKey) {
                $keyFinded = array_search($uniqueKey, $keys);
                unset($keys[$keyFinded]);
            }
            $keysDouble = '';
            $count = 0;
            foreach ($keys as $key) {
                if ($count > 0) $keysDouble .= ', ' . $key;
                else $keysDouble .= $key . ', ';
                $count++;
            }
            return $keysDouble;
        } else return 'Doubles not';
    }
}
