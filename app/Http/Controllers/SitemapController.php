<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App;
use DB;
use App\Category;

class SitemapController extends Controller
{
    private $structureCategories = [];
    private $rest;
    private $submainmenu;
    private $mainmenu;

    public function __construct()
    {
        $this->getMainmenu();

        $this->getCategories();

        \Storage::disk('local')->put('mainmenu.json', json_encode($this->mainmenu));
        unset($this->mainmenu);

        //$brand = Category::with('aliases_categories')->where(['brand' => 1, 'status' => 1])->select('id', '')->orderByDesc('sort')->get();
        $brand = DB::select('SELECT
                  categories.name,
                  categories.id,
                  aliases_categories.alias,
                  aliases_categories_1.alias AS par_al
                FROM aliases_categories
                  INNER JOIN categories
                    ON aliases_categories.id = categories.id
                  INNER JOIN aliases_categories aliases_categories_1
                    ON categories.category = aliases_categories_1.id
                WHERE categories.status = 1
                AND categories.brand = 1
                ORDER BY categories.brand_sort DESC');
        \Storage::disk('local')->put('brand.json', json_encode($brand));

        $categories = DB::select('SELECT categories.name, aliases_categories.alias, categories.id, categories.sort FROM aliases_categories
                          INNER JOIN categories
                            ON aliases_categories.id = categories.id
                            WHERE categories.status = 1
                            AND categories.category = categories.id
                            AND (categories.menu <> 2 OR categories.menu is null)
                            ORDER BY categories.sort');

        foreach ($categories as $key => $cat) {
            $this->submainmenu = array();
            switch ($key) {
                case 0:
                    $amount = 8;
                    break;
                case 1:
                    $amount = 8;
                    break;
                case $key == 2 || $key == 3:
                    $amount = 2;
                    break;
                case 4:
                    $amount  = 4;
                    break;
            }
            $this->getSubmenu($cat, $alias = null, $amount);

            $subcatArr[] = $this->submainmenu;
        }
        //order
        foreach ($subcatArr as $array) {
            $topArray = array();
            $bottomArray = array();
            foreach ($array as $uri2 => $value) {
                $depthDomen = count(explode('/', $uri2));
                switch ($depthDomen) {
                    case 2:
                        $topArray[$uri2] = $value;
                        break;
                    case 3:
                        $bottomArray[$uri2] = $value;
                        break;
                }
            }
            $subcat[] = array_merge($topArray, $bottomArray);
        }

        \Storage::disk('local')->put('subcat.json', json_encode($subcat));
        \Storage::disk('local')->put('categories.json', json_encode($categories));
        unset($subcat);
        unset($categories);
    }

    public function go()
    {
        $host = $_SERVER['HTTP_HOST'];
        // create sitemap
        $sitemap = App::make("sitemap");

        // set cache
        //$sitemap->setCache('laravel.sitemap-posts', 3600);

        // add products
        $categories = json_decode(\Storage::get('categories.json'));
        array_pop($categories);
        foreach($categories as $category){
            $products = DB::select('SELECT
                              aliases_products.alias
                            FROM aliases_products
                              INNER JOIN product_categories
                                ON aliases_products.id = product_categories.product_id
                              INNER JOIN list_products
                                ON aliases_products.id = list_products.id
                            WHERE product_categories.category_id = ?
                            AND list_products.status = 1', [$category->id]);
            foreach ($products as $p) {
                $sitemap->add('https://'.$host.'/'.$category->alias.'/'.$p->alias, null, '1.0', 'weekly');
            }
        }
        //add brands
        /*$brands = DB::select('SELECT
                      aliases_brands.alias
                    FROM list_brands
                      INNER JOIN aliases_brands
                        ON list_brands.id = aliases_brands.id
                    WHERE list_brands.status = 1');
        foreach ($brands as $br) {
            $sitemap->add('https://'.$host.'/'.$br->alias, null, '0.5', 'weekly');
        }*/
        // add categories
        foreach ($this->structureCategories as $cat) {
            $sitemap->add('https://'.$host.'/'.$cat->alias, null, '1.0', 'weekly');
        }
        //informations
        $information = DB::select('SELECT
                          aliases_informations.alias
                        FROM aliases_informations
                          INNER JOIN informations
                            ON aliases_informations.id = informations.id
                        WHERE informations.status = 1');
        foreach ($information as $info) {
            $sitemap->add('https://'.$host.'/'.$info->alias, null, '0.5', 'weekly');
        }
        //posts
        $posts = DB::select('SELECT
                      aliases_posts.alias
                    FROM list_blogs
                      INNER JOIN aliases_posts
                        ON list_blogs.id = aliases_posts.id
                    WHERE list_blogs.status = 1');
        foreach ($posts as $post) {
            $sitemap->add('https://'.$host.'/'.'dver/'.$post->alias, null, '0.5', 'weekly');
        }
        $sitemap->add('https://'.$host.'/'.'all-news', null, '0.5', 'weekly');
        // show sitemap
        return $sitemap->render('xml');
    }

    public function getSubcategories($val)
    {
        $categories = DB::select('SELECT categories.name, categories.id, aliases_categories.alias, categories.image, categories.sort, categories.menu, categories.category FROM aliases_categories
                            INNER JOIN categories
                            ON aliases_categories.id = categories.id
                            WHERE categories.category <> categories.id
                            AND categories.status = 1
                            AND categories.category = ? 
                            ORDER BY categories.sort', [$val->id]);
        if (count($categories) > 0) {
            foreach ($categories as $category) {
                $category->alias = $val->alias . '/' . $category->alias;
                if(mb_strlen($category->image) > 0){
                    $category->image = 'image/'.$category->image;
                }

                $this->structureCategories[] = $category;

                //check on isset subcategories
                $subcat2 = DB::select('SELECT categories.name, categories.id, aliases_categories.alias, categories.image, categories.sort, categories.menu, categories.category FROM aliases_categories
                            INNER JOIN categories
                            ON aliases_categories.id = categories.id
                            WHERE categories.category <> categories.id
                            AND categories.status = 1
                            AND categories.category = ? 
                            ORDER BY categories.sort', [$category->id]);

                if (count($subcat2) > 0) {
                    $this->getSubcategories($category);
                }
            }

        }
    }

    public function getCategories()
    {
        $categories = DB::select('SELECT categories.name, categories.id, aliases_categories.alias, categories.image, categories.sort, categories.menu, categories.category FROM aliases_categories
                          INNER JOIN categories
                            ON aliases_categories.id = categories.id
                            WHERE categories.status = 1
                            AND categories.category = categories.id
                            ORDER BY categories.sort');

        foreach ($categories as $val) {
            $val->image = 'image/' . $val->image;
            $this->structureCategories[] = $val;

            $this->getSubcategories($val);

        }
    }
    /**
     * @param $val
     * @param $submainmenu
     * @return mixed
     */
    public function getSubmenu($val, $alias, $amount)
    {
        isset($amount) ? $limit = ' LIMIT '.$amount: $limit = '';//' AND categories.menu = 1 ';
        $productAmount = count(DB::table('product_categories')->where('category_id', $val->id)->get());
        if($productAmount > 0){
            $categories = DB::select('SELECT
                              categories.name,
                              categories.id,
                              aliases_categories.alias,
                              categories.image,
                              MIN(list_products.price) AS min,
                              MAX(list_products.price) AS max
                            FROM aliases_categories
                              INNER JOIN categories
                                ON aliases_categories.id = categories.id
                              INNER JOIN product_categories
                                ON categories.id = product_categories.category_id
                              INNER JOIN list_products
                                ON product_categories.product_id = list_products.id
                            WHERE categories.category <> categories.id
                            AND categories.status = 1
                            AND categories.category = ?
                            AND list_products.status = 1
                            GROUP BY aliases_categories.alias,
                                     categories.id,
                                     categories.name,
                                     categories.image
                            ORDER BY categories.sort'
                .$limit, [$val->id]);
        } else {
            $categories = DB::select('SELECT
                              categories.name AS price,
                              categories.id,
                              aliases_categories.alias,
                              categories.image,
                              pages.name
                            FROM aliases_categories
                              INNER JOIN categories
                                ON aliases_categories.id = categories.id
                              INNER JOIN pages
                                ON pages.id = categories.id
                            WHERE categories.category <> categories.id
                            AND categories.status = 1
                            AND categories.category = ?
                            GROUP BY aliases_categories.alias,
                                     categories.id,
                                     categories.name,
                                     categories.image,
                                     pages.name
                            ORDER BY categories.sort'.$limit,[$val->id]);
        }

        (isset($amount)) ? $this->rest = $amount - count($categories): $limit = '';

        if($this->rest > 0) $limit = ' LIMIT '.$this->rest;
        else $limit = '';

        foreach ($categories as $category) {
            if (empty($alias)) $uri = $val->alias . '/' . $category->alias;
            else $uri = $alias . '/' . $category->alias;
            if($productAmount > 0) $this->submainmenu[$uri] = array('name' => $category->name, 'image' => $category->image, 'min' => $category->min, 'max' => $category->max);
            else $this->submainmenu[$uri] = array('name' => $category->name, 'image' => $category->image, 'price' => explode(' | ', $category->price)[1]);

            if($this->rest > 0 || empty($amount)){
                //check on isset subcategories
                $subcategories = DB::select('SELECT
                                  categories.name,
                                  aliases_categories.alias,
                                  categories.image,
                                  MIN(list_products.price) AS min,
                                  MAX(list_products.price) AS max,
                                  categories.id
                                FROM aliases_categories
                                  INNER JOIN categories
                                    ON aliases_categories.id = categories.id
                                  INNER JOIN product_categories
                                    ON categories.id = product_categories.category_id
                                  INNER JOIN list_products
                                    ON product_categories.product_id = list_products.id
                                WHERE categories.category <> categories.id
                                AND categories.status = 1
                                AND categories.category = ?
                                AND list_products.status = 1
                                GROUP BY aliases_categories.alias,
                                         categories.name,
                                         categories.image,
                                         categories.id
                                ORDER BY categories.sort'
                                .$limit, [$category->id]);
                $countSubCat = count($subcategories);
                if ($countSubCat > 0) {
                    if(isset($amount)) $amount = $this->rest;
                    $this->getSubmenu($category, $uri, $amount);
                }
            }

        }
    }

    /**
     * @param $categoriesMenu
     */
    public function getMainmenu()
    {
        $categoriesMenu = DB::select('SELECT categories.name, aliases_categories.alias, categories.id FROM aliases_categories
                          INNER JOIN categories
                            ON aliases_categories.id = categories.id
                            WHERE categories.status = 1
                            AND categories.menu = 1
                            AND categories.category = categories.id
                            ORDER BY categories.sort');

        foreach ($categoriesMenu as $val) {
            $this->submainmenu = array();
            $this->submainmenu[0] = $val->name;

            $this->getSubmenu($val, $alias = null, $amount = 20);

            $this->mainmenu[$val->alias] = $this->submainmenu;
        }
        foreach ($this->mainmenu as $uri1 => $array) {
            $topArray = array();
            $bottomArray = array();
            foreach ($array as $uri2 => $value) {
                if ($uri2 === 0) {
                    $nameCat = $value;
                } else {
                    $depthDomen = count(explode('/', $uri2));
                    switch ($depthDomen) {
                        case 2:
                            $topArray[$uri2] = $value;
                            break;
                        case 3:
                            $bottomArray[$uri2] = $value;
                            break;
                    }
                }
            }
            $this->mainmenu[$uri1] = array_merge(array(0 => $nameCat), $topArray, $bottomArray);
        }
    }
}
