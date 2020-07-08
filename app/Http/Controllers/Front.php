<?php

namespace App\Http\Controllers;

use App\AliasCategory;
use App\AliasInformation;
use App\AliasPost;
use App\AliasProduct;
use App\Brand;
use App\Http\Controllers\FrontendDataEntry\RequestsController;
use App\Information;
use App\BlogPost;
use App\ListBlog;
use App\ListProduct;
use App\Page;
use App\ProductDiscount;
use App\ProductImage;
use App\ProductOption;
use Illuminate\Http\Request;
use App\ListBrand;
use App\Category;
use App\Product;
use Image;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use DB;
use App\Http\Controllers\Controller;

//use App\Http\Requests;
//use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use App\RequestCustomer;

use Illuminate\Support\Facades\View;

class Front extends Controller
{
    var $brands;
    var $categories;
    var $products;
    var $title;
    var $description;
    private $rest;
    private $request_uri;
    private $currentAlias;
    private $page;

    public function __construct()
    {
    	  $this->request_uri = explode('/', $_SERVER['REQUEST_URI']);
        $this->currentAlias = array_pop($this->request_uri);

        $mainmenu = \Storage::get('mainmenu.json');
        $categories = \Storage::get('categories.json');
        $brand = \Storage::get('brand.json');

        //$brand = ListBrand::with('alias_brand')/*->where('status', '1')*/
        //->limit(5)->offset(1)->get();
        $requests = RequestCustomer::where('status', 1)->orderBy('created_at', 'DESC')->limit(1)->get();
        $info = Information::with('alias_information')->get();
        $post = ListBlog::with('alias_post')->where('status', '1')->limit(2)->offset(0)->orderBy('created_at', 'desc')->get();
        
        $this->page = new Page();
        $this->page->title = 'error404';
        $this->page->name = 'error404';
        $this->page->keywords = 'error404';
        $this->page->meta_description = 'Извините, ошибка 404! Такая страница не найдена';

        $categories = json_decode($categories);
        $raspr = array_pop($categories);

        View::share([
            'mainmenu' => json_decode($mainmenu),
            'brands' => json_decode($brand),
            'cur_alias' => $this->currentAlias,
            'requests' => $requests,
            'info' => $info,
            'post' => $post,
            'cat' => $categories,
            'raspr' => $raspr,
        ]);
    }

    public function list_blog()
    {
        $this->page->title = 'Все новости от интернет-магазина "budynak.by"';
        $this->page->name = 'Все новости по дверям, отделке, ремонте и строительству от интернет-магазина "budynak.by"';
        $this->page->meta_description = 'Все новости от интернет-магазина "budynak.by"';
        $this->page->keywords = 'Все новости';
        $this->page->alias = 'all-news';
        $listBlog = DB::select('SELECT
                                  list_blogs.name,
                                  list_blogs.image,
                                  aliases_posts.alias,
                                  blog_posts.content,
                                  list_blogs.created_at
                                FROM aliases_posts
                                  INNER JOIN list_blogs
                                    ON aliases_posts.id = list_blogs.id
                                  INNER JOIN blog_posts
                                    ON blog_posts.id = list_blogs.id
                                WHERE list_blogs.status = 1
                                ORDER BY list_blogs.created_at DESC');
        View::share(['page' => $this->page]);
        return view('list_blog', ['page' => $this->page, 'listBlog' => $listBlog]);
    }

    /**
     * @return View
     */
    public function blog($name)
    {
        $idBlog = AliasPost::where('alias', $name)->get();
        $blog = DB::select('SELECT
                  aliases_posts.alias,
                  blog_posts.content,
                  blog_posts.name,
                  blog_posts.title,
                  blog_posts.meta_description,
                  blog_posts.keywords
                FROM aliases_posts
                  INNER JOIN blog_posts
                    ON aliases_posts.id = blog_posts.id
                WHERE blog_posts.id = ?', [$idBlog[0]->id]);
        
        $this->page->title = $blog[0]->title;
        unset($blog[0]->title);
        $this->page->name = $blog[0]->name;
        $this->page->meta_description = $blog[0]->meta_description;
        unset($blog[0]->meta_description);
        $this->page->keywords = $blog[0]->keywords;
        unset($blog[0]->keywords);
        View::share(['page' => $this->page]);
        return view('blog', ['blog' => $blog, 'back' => ['alias' => 'all-news', 'name' => 'Все новости']]);
    }

    public function sitemap()
    {        
        $this->page->title = 'Карта сайта';
        $this->page->name = 'Карта сайта';
        $this->page->meta_description = 'Карта сайта';
        $this->page->keywords = 'Карта сайта';
        View::share(['page' => $this->page]);
        return view('sitemap', ['page', $this->page]);
    }

    public function infopage($name)
    {
        $id = AliasInformation::where('alias', $name)->get();
        if(count($_GET) > 0 && strpos(array_keys($_GET)[0], 'entertainment') === 0) return \redirect($name);
        if(count($id) === 0) {
        	View::share('page', $this->page);
        	return abort('404');
        }	
        $info = DB::select('SELECT
                              informations.name,
                              informations.title,
                              informations.meta_description,
                              informations.content,
                              informations.keywords,
                              aliases_informations.alias
                            FROM aliases_informations
                              INNER JOIN informations
                                ON aliases_informations.id = informations.id
                            WHERE informations.id = ?', [$id[0]->id]);
        
        $this->page->title = $info[0]->title;
        unset($info[0]->title);
        $this->page->name = $info[0]->name;
        $this->page->meta_description = $info[0]->meta_description;
        unset($info[0]->meta_description);
        $this->page->keywords = $info[0]->keywords;
        unset($info[0]->keywords);
        View::share(['page' => $this->page]);
        return view('blog', ['blog' => $info, 'back' => []]);
    }

    public function index()
    {
        $this->page->title = 'Budynak.by - купить двери в Минске, Могилеве, Витебске по хорошим ценам и с гарантией';
        $this->page->name = 'Добро пожаловать в budynak.by - двери, фурнитура и другие товары для дома';
        $this->page->keywords = 'двери,межкомнатные двери,входные двери в бресте,купить входные двери в минске недорого,двери в витебске,двери недорого,двери беларусь,двери под ключ,входные двери под заказ,офисные двери,интернет магазин межкомнатных дверей,входные и межкомнатные двери,витебские двери,интернет магазин дверей в беларуси,входные двери под заказ,межкомнатные двери интернет магазин в белоруссии,интернет магазин межкомнатных дверей в беларуси';
        $this->page->meta_description = 'Предлагаем купить двери входные и межкомнатные, фурнитуру с доставкой и установкой в Минске, Могилеве, Гомеле, Гродно, Бресте, Витебске';
        $this->page->content = '<span><strong>Предлагаем купить двери входные, двери межкомнатные и дверную фурнитуру&nbsp;в&nbsp;Минске, Могилеве, Витебске, Гомеле, Бресте, Гродно&nbsp;а также в областных центрах и районах!</strong><br>
        Мы поможем Вам двери купить недорого, не выходя из дома. Наш онлайн-сервис&nbsp;budynak.by постоянно совершенствуется, делая более удобным выбор подходящих моделей для покупки. Большой каталог моделей различные по характеристиками и дизайну от известных производителей белорусских, российских, китайских дверей и фурнитуры с фотографиями, ценами и подробными описаниями. Для покупки с гарантией,&nbsp;качеством можете позвонить нам и заказать выезд нашего специалиста.</span>
        <p><h3>Купить двери через интернет-магазин budynak.by, это значит получить:</h3></p>
			<p><img alt="" src="image/data/content/Banner.jpg" style="width: 800px; height: 232px;" /></p>
            <ul>
                <li><span>Выгодную покупку дверей, не выходя из дома ==&gt; Выезд нашего мастера на замер проемов убережет Вас от проблем, связанными с неожиданными особенностями Ваших &quot;стандартных&quot; проемов или выбранными Вами дверей;</span></li>
                <li><span>Внушительный ассортимент ==&gt; У нас все популярные и известные производители дверей, представленные на рынке не только Минска, но и всей Беларуси;</span></span></li>
                <li><span>Установку дверей от нашего магазина ==&gt; Это гарантия того, что Вы купили не кусок металла или дерево, а дверь в ВАШЕМ ПРОЕМЕ&nbsp; ПОД ГАРАНТИЕЙ МАГАЗИНА И ПРОИЗВОДИТЕЛЯ.</span></span></li>
            </ul>
		</div>';
		$this->page->canonical = '<link rel=”canonical” href="'.secure_url('/').'" />';
        View::share('page', $this->page);

        $subcat = \Storage::get('subcat.json');

        return view('home', [
            'allSubcats' => json_decode($subcat)
        ]);
    }

    public function rasprogaja()
    {
        $categories = json_decode(\Storage::get('categories.json'));
        $rasprodaga = array_pop($categories);


        $productDB = DB::select('SELECT
              list_products.name,
              list_products.image,
              list_products.price,
              aliases_products.alias,
              product_discounts.discount,
              aliases_categories.alias AS al_cat,
              list_products.id,
              list_products.status,
  												product_discounts.date_end
            FROM list_products
              INNER JOIN aliases_products
                ON aliases_products.id = list_products.id
              INNER JOIN product_categories
                ON product_categories.product_id = list_products.id
              LEFT OUTER JOIN product_discounts
                ON product_discounts.product_id = list_products.id
              INNER JOIN product_categories product_categories_1
                ON product_categories.product_id = product_categories_1.product_id
              INNER JOIN aliases_categories
                ON aliases_categories.id = product_categories_1.category_id
              INNER JOIN categories
                ON categories.id = product_categories_1.category_id
            WHERE categories.category = categories.id
            AND (product_discounts.discount IS NOT NULL
            AND product_discounts.date_end <= CURDATE()
            OR product_categories.category_id = ?)
            AND list_products.status = 1 
            AND product_discounts.discount IS NOT NULL', [$rasprodaga->id]);
        $campareId = '';
        $product = [];
        foreach($productDB as $pDB){
            if($pDB->discount && 
            	$campareId !== $pDB->id &&
            	 $pDB->al_cat !== 'rasprodaga' &&
                $pDB->date_end >= date('Y-m-d')){
                $campareId = $pDB->id;
                $pDB->alias = $pDB->al_cat . '/' . $pDB->alias;
                unset($pDB->al_cat);
                $product[] = $pDB;
            }
        }
        $this->page = null;
        $perPage = 20;
        $option = [];
        $this->page = $this->page ?: (LengthAwarePaginator::resolveCurrentPage() ?: 1);
        $product = $product instanceof Collection ? $product : Collection::make($product);
        $paginate = new LengthAwarePaginator($product->forPage($this->page, $perPage), $product->count(), $perPage, $this->page, $option);
        $paginate->setPath('rasprodaga');

        $this->page = Page::find($rasprodaga->id);
        View::share('page', $this->page);
        return view('list_cat', ['products' => $paginate]);
    }

    public function subcat_product($name)
    {
        $alias = AliasCategory::where('alias', $name)->get();
        if (count($alias) > 0) {
            return $this->getPageCategory($alias);
        } else {
            $alias = AliasProduct::where('alias', $name)->get();
            if(count($alias) === 0) {
            	View::share('page', $this->page);
            	return abort('404');
            }
            $id = $alias[0]->id;
            $product = Product::find($id);
            $category = DB::select('SELECT
                      aliases_categories.alias
                    FROM product_categories
                      INNER JOIN categories
                        ON product_categories.category_id = categories.id
                      INNER JOIN aliases_categories
                        ON categories.id = aliases_categories.id
                    WHERE product_categories.product_id = ?
                    AND categories.status = 1
                    AND categories.category = categories.id', [$id]);
            $uriCat = array_pop($this->request_uri);

            if(count($_GET) > 0 && strpos(array_keys($_GET)[0], 'entertainment') === 0 
            	|| $category[0]->alias !== $uriCat 
            	|| preg_match('/([A-Z]| )/',$name)) return \redirect($category[0]->alias.'/'.$alias[0]->alias);
            $productDiscount = ProductDiscount::where('product_id', $id)->get();
            if(count($productDiscount) > 0 && mb_strlen($productDiscount[0]->date_end) > 0 && $productDiscount[0]->date_end >= date('Y-m-d')){
                $product->discount = $productDiscount[0]->discount;
            }
            
            (mb_strlen($product->title) > 0) ? $this->page->title = $product->title : $this->page->title = $product->name;
            unset($product->title);
            $this->page->name = $product->name;
            $this->page->description = $product->meta_description;
            unset($product->meta_description);
            $this->page->keywords = $product->keywords;
            unset($product->keywords);
            $this->page->min = round($product->price, 2);
            $this->page->canonical = '<link rel=”canonical” href="'.secure_url($category[0]->alias.'/'.$alias[0]->alias).'" />';

            $brand = DB::select('SELECT
                      categories.name,
                      aliases_categories.alias
                    FROM product_categories
                      INNER JOIN categories
                        ON product_categories.category_id = categories.id
                      INNER JOIN aliases_categories
                        ON categories.id = aliases_categories.id
                    WHERE product_categories.product_id = ?
                    AND categories.brand = 1
                    AND categories.status = 1', [$id]);
            if(count($brand) > 0){
                $this->page->brand = [
                    'name' => $brand[0]->name,
                    'alias' => $brand[0]->alias
                ];
            } else $this->page->brand = null;
            $image = DB::table('product_image')->where('product_id', $id)->select('image')->orderBy('sort')->get();
            $optProd = DB::select('SELECT
                                      `option`.name,
                                      product_option.required,
                                      product_option.option_id
                                    FROM product_option
                                      INNER JOIN `option`
                                        ON product_option.option_id = `option`.id
                                    WHERE product_option.product_id = ?', [$id]);
            $valProd = DB::select('SELECT
                                      option_value.image,
                                      product_option_value.price,
                                      product_option_value.id,
                                      product_option_value.value_id,
                                      value.name,
                                  product_option_value.option_id
                                    FROM product_option_value
                                      INNER JOIN value
                                        ON product_option_value.option_id = value.option_id
                                        AND product_option_value.value_id = value.id
                                      INNER JOIN option_value
                                        ON product_option_value.value_id = option_value.value_id
                                        AND product_option_value.option_id = option_value.option_id
                                    WHERE product_option_value.product_id = ? 
                                    ORDER BY option_value.sort_order', [$id]);
            
            View::share(['page' => $this->page]);
            return view('product', [
                'product' => $product,
                'image' => $image,
                'optProds' => $optProd,
                'valProds' => $valProd,
            ]);
        }
    }

    public function categories(Request $request)
    {
        $urlAr = explode('/', $request->url());
        $name = array_pop($urlAr);
        $alias = AliasCategory::where('alias', $name)->get();
        $val = $alias[0];
        $key = key($_GET);
        if($key && $key !== 'page') return redirect($val->alias);
        $this->page = Page::find($val->id);
        $this->submainmenu = array();
        $this->getSubmenu($val);

        $minAr = [];
        foreach($this->submainmenu as $sm){
            $minAr[] = (float) $sm['min'];
        }
        if(count($minAr) > 0) $this->page->min = min($minAr);
        $page = null;
        $perPage = 24;
        $option = [];
        $page = $page ?: (LengthAwarePaginator::resolveCurrentPage() ?: 1);
        $this->submainmenu = $this->submainmenu instanceof Collection ? $this->submainmenu : Collection::make($this->submainmenu);
        $paginate = new LengthAwarePaginator($this->submainmenu->forPage($page, $perPage), $this->submainmenu->count(), $perPage, $page, $option);
        $paginate->setPath($val->alias);
        $url = secure_url($val->alias);
        if(count($_GET) > 0){
            $lastPage = $paginate->lastPage();
            $numberPage = $_GET['page'];
            if($numberPage > 1) $this->page->prev = '<link rel=”prev” href="'. $url . '?page='. ($numberPage-1) .'" />';
            if($numberPage < $lastPage) $this->page->next = '<link rel=”next” href="'.$url . '?page='. ($numberPage+1) .'" />';
            $this->page->title = 'Страница ' . $_GET['page'] . '. Раздела ' . $this->page->title;
            $this->page->meta_description = 'Страница ' . $_GET['page'] . '. Описание: ' . $this->page->meta_description;
        }
        $this->page->canonical = '<link rel=”canonical” href="'.$url.'" />';
        View::share('page', $this->page);
        return view('categories', ['subcats' => $paginate]);
    }
    public function remont_otdelka(Request $request){
    	$urlAr = explode('/', $request->url());
        $name = array_pop($urlAr);
        $alias = AliasCategory::where('alias', $name)->get();
        $val = $alias[0];
        $this->page = Page::find($val->id);
        $this->submainmenu = array();
        $this->submainmenu = DB::select('SELECT
			  categories.name AS price,
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
			ORDER BY categories.sort', [$val->id]);
        foreach ($this->submainmenu as $key => $value) {
            $this->submainmenu[$key]->price = explode(' | ', $value->price)[1];
            $this->submainmenu[$key]->alias = $name .'/'. $value->alias;
        }
        View::share('page', $this->page);
        return view('cat_rem_otd', ['subcats' => $this->submainmenu]);
    }

    public function requests()
    {
        
        $this->page->title = 'Список отзывов';
        $this->page->name = 'Список отзывов';
        $this->page->meta_description = 'Список отзывов';
        $this->page->keywords = 'отзывы';
        View::share(['page' => $this->page]);
        $requests = RequestCustomer::where('status', 1)->orderBy('created_at', 'DESC')->get();
        return view('list_requests', ['requests' => $requests]);
    }

    public function search(){
        $search = trim($_POST['search']);
        $search = stripslashes($search);
        $search = htmlspecialchars($search);
        $listProd = DB::select('SELECT
              list_products.id,
              list_products.name,
              list_products.image,
              list_products.price,
              aliases_products.alias,
              product_discounts.discount,
              aliases_categories.alias AS al_cat
            FROM list_products
              INNER JOIN aliases_products
                ON aliases_products.id = list_products.id
              INNER JOIN product_categories
                ON product_categories.product_id = list_products.id
              LEFT OUTER JOIN product_discounts
                ON product_discounts.product_id = list_products.id
              INNER JOIN product_categories product_categories_1
                ON product_categories.product_id = product_categories_1.product_id
              INNER JOIN aliases_categories
                ON aliases_categories.id = product_categories_1.category_id
              INNER JOIN categories
                ON categories.id = product_categories_1.category_id
            WHERE list_products.name LIKE \'%'.$search.'%\'
            AND categories.category = categories.id 
            AND list_products.status = 1
        ORDER BY list_products.price');
        if(count($listProd)){
            $count = 0;
            $product[$count] = $listProd[0];
            foreach($listProd as $lp){
                if($lp->id !== $product[$count]->id){
                    $product[++$count] = $lp;
                }
            }
        } else $product = $listProd;

        $this->page->title = 'Поиск товара';
        $this->page->name = 'Поиск товара';
        $this->page->meta_description = '';
        $this->page->keywords = '';
        $this->page->alias = 'search';
        View::share('page', $this->page);
        return view('search', ['products' => $product, 'word' => $_POST['search']]);
    }

    /**
     * @param $val
     * @param $submainmenu
     * @return mixed
     */
    public function getSubmenu($val, $alias = null, $amount = null)
    {
        isset($amount) ? $limit = ' LIMIT ' . $amount : $limit = '';
        $categories = DB::select('SELECT
                          categories.name,
                          categories.id,
                          aliases_categories.alias,
                          categories.image,
                          MAX(list_products.price) AS max,
                          MIN(list_products.price) AS min
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
                                    . $limit, [$val->id]);
        (isset($amount)) ? $this->rest = $amount - count($categories) : $limit = '';
        if ($this->rest > 0) $limit = ' LIMIT ' . $this->rest;
        else $limit = '';
        foreach ($categories as $category) {
            if (empty($alias)) $uri = $val->alias . '/' . $category->alias;
            else $uri = $alias . '/' . $category->alias;
            $this->submainmenu[$uri] = array('name' => $category->name, 'image' => $category->image, 'max' => $category->max, 'min' => $category->min);
            if ($this->rest > 0 || empty($amount)) {
                //check on isset subcategories
                $subcategories = DB::select('SELECT
                          categories.name,
                          categories.id,
                          aliases_categories.alias,
                          categories.image,
                          MAX(list_products.price) AS max,
                          MIN(list_products.price) AS min
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
                    . $limit, [$category->id]);
                $countSubCat = count($subcategories);
                if ($countSubCat > 0) {
                    if (isset($amount)) $amount = $this->rest;
                    $this->getSubmenu($category, $uri, $amount);
                }
            }
        }
    }
    /**
     * @param $alias
     * @return View
     */
    public function getPageCategory($alias)
    {
        $id = $alias[0]->id;
        $aliases = DB::select('SELECT
                  aliases_categories.alias AS par_alias,
                  aliases_categories_1.alias AS alias
                FROM categories
                  INNER JOIN categories categories_1
                    ON categories.category = categories_1.id
                  INNER JOIN aliases_categories
                    ON aliases_categories.id = categories_1.id
                  INNER JOIN aliases_categories aliases_categories_1
                    ON categories.id = aliases_categories_1.id
                WHERE categories.status = 1
                AND categories.id = ?
                AND categories_1.id = categories.category',[$id]);

        $uriCat = array_pop($this->request_uri);
        if(count($aliases) === 0) {
            View::share('page', $this->page);
            return abort('404');
        }

        $minPrice = DB::select('SELECT
              MIN(list_products.price) AS min
            FROM list_products
              INNER JOIN product_categories
                ON list_products.id = product_categories.product_id
            WHERE product_categories.category_id = ?', [$id]);

        $maxPrice = DB::select('SELECT
              MAX(list_products.price) AS max
            FROM list_products
              INNER JOIN product_categories
                ON list_products.id = product_categories.product_id
            WHERE product_categories.category_id = ?', [$id]);

        $url = secure_url($aliases[0]->par_alias.'/'.$aliases[0]->alias);
        $this->page = Page::find($id);
        $this->page->min = round($minPrice[0]->min);
        $this->page->max = round($maxPrice[0]->max);
        $this->page->canonical = '<link rel=”canonical” href="'.$url.'" />';

        if(count($_GET) > 0 && array_key_exists('range_price', $_GET) && $_GET['range_price']){
            $rangeAr = explode(',', $_GET['range_price']);

            $products = DB::table('list_products')
                ->join('aliases_products', 'aliases_products.id', '=', 'list_products.id')
                ->join('product_categories', 'product_categories.product_id', '=', 'list_products.id')
                ->leftjoin('product_discounts', 'product_discounts.product_id', '=', 'list_products.id')
                ->select('list_products.name', 'list_products.image', 'list_products.price', 'aliases_products.alias', 'product_discounts.discount')
                ->where(['product_categories.category_id' => $id, 'status' => 1])
                ->whereBetween('list_products.price', $rangeAr)
                ->orderBy('list_products.price')
                //->paginate(20);
                ->get();

            $this->page->rangeMin = round($rangeAr[0]);
            $this->page->rangeMax = round($rangeAr[1]);

        } else {
            if(count($_GET) > 0 && strpos(array_keys($_GET)[0], 'entertainment') === 0 ||
                $aliases[0]->par_alias !== $uriCat
                || preg_match('/([A-Z]| |index.php)/',$this->currentAlias))
                return \redirect($aliases[0]->par_alias.'/'.$aliases[0]->alias);

            $products = DB::table('list_products')
                ->join('aliases_products', 'aliases_products.id', '=', 'list_products.id')
                ->join('product_categories', 'product_categories.product_id', '=', 'list_products.id')
                ->leftjoin('product_discounts', 'product_discounts.product_id', '=', 'list_products.id')
                ->select('list_products.name', 'list_products.image', 'list_products.price', 'aliases_products.alias', 'product_discounts.discount')
                ->where(['product_categories.category_id' => $id, 'status' => 1])
                ->orderBy('list_products.price')
                //->paginate(20);
                ->get();
        }

        $arr = explode('?page', $this->currentAlias);
        if(count($arr) > 1) {
          $this->currentAlias = $arr[0];
        }
        $arr = explode('?range_price', $this->currentAlias);
        if(count($arr) > 1) {
          $arr = explode('&page', $this->currentAlias);
          if(count($arr) > 1)
          $this->currentAlias = $arr[0];
        }

        $page = null;
        $perPage = 20;
        $option = [];
        $page = $page ?: (LengthAwarePaginator::resolveCurrentPage() ?: 1);
        $products = $products instanceof Collection ?$products : Collection::make($products);
        $paginate = new LengthAwarePaginator($products->forPage($page, $perPage), $products->count(), $perPage, $page, $option);
        $paginate->setPath($this->currentAlias);
        //$url = secure_url($this->currentAlias);
        if(count($_GET) > 0 && array_key_exists('page', $_GET)){
            $lastPage = $paginate->lastPage();
            $numberPage = $_GET['page'];
            if($numberPage > 1) $this->page->prev = '<link rel=”prev” href="'. $this->currentAlias . '?page='. ($numberPage-1) .'" />';
            if($numberPage < $lastPage) $this->page->next = '<link rel=”next” href="'.$this->currentAlias . '?page='. ($numberPage+1) .'" />';
            $this->page->title = 'Страница ' . $_GET['page'] . '. Раздела ' . $this->page->title;
            $this->page->meta_description = 'Страница ' . $_GET['page'] . '. Описание: ' . $this->page->meta_description;
        }

        View::share('page', $this->page);
        return view('list_cat',
            ['products' => $paginate]);
    }
}