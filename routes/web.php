<?php
Route::get('/laravel-filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show');
Route::post('/laravel-filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload');
//Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
//    \UniSharp\LaravelFilemanager\Lfm::routes();
//});

Route::get('/filemanager/dialog.php', function(){
    return include base_path(). '/filemanager/dialog.php';
})->middleware('auth');
Route::post('/request', 'FrontendDataEntry\RequestsController@create');
Route::post('/cart', 'CartController@make');
Route::get('/cart', 'CartController@show');
Route::post('/search', 'Front@search');
Route::get('/spisok-otzyvov', 'Front@requests');
Auth::routes();
Route::get('sitemap', 'SitemapController@go');
Route::get('yaml', 'YamlController@index');
Route::get('/', 'Front@index');
Route::group(['middleware' => ['auth']], function(){
    Route::get('home', function () {
        return view('admin.dashboard');
    });
});
/*Route::get('dveri-mejkomnatnie/{category}/{product}, function($product){
				return redirect("dveri/$product");
});*/
Route::group(['prefix' => 'vhodnye-dveri'], function () {
    Route::get('/', 'Front@categories');
    Route::get('/{name}', 'Front@subcat_product');
    Route::get('/{category}/{product}', function ($category, $product) {
        return redirect('/vhodnye-dveri/' . $product);
    });
    Route::get('/{category1}/{category2}/{product}', function ($category1, $category2, $product) {
        return redirect('/vhodnye-dveri/' . $product);
    });
});
Route::group(['prefix' => 'rasprodaga'], function () {
    Route::get('/{name}', 'Front@subcat_product');
});
Route::get('mejkomnatnye-dveri/{category}/{product}', function ($category, $product) {
        return redirect('/dveri/' . $product);
    });
Route::get('mejkomnatnye-dveri/{product}', function($product){
    return redirect("dveri/$product"); 
});

Route::get('dveri-mejkomnatnie/{product}', function($product){
    return redirect("dveri/$product");
});
Route::get('kresla-stoli-stulja/{product}', function($product){
    return redirect("dacha-otdih/$product");
});
Route::get('ustanovka/ustanovka-dverey', function(){
    return redirect('ustanovka-dverey');
});
Route::get('contacts', function(){
    return redirect('contact');
});
Route::get('dostavka-dverey', function(){
    return redirect('info-dostavka');
});
Route::group(['prefix' => 'otdelka-i-remont-kvartiry-doma-dachi'], function () {
    Route::get('/', 'Front@remont_otdelka');
    Route::get('/{name}', 'Front@subcat_product');
});
Route::get('/dveri/ ladora-kvadro', function(){
    $get = '';
    if(count($_GET) > 0) $get = '?page='.$_GET['page'];
    return redirect('/dveri/ladora-kvadro'.$get);
});
Route::group(['prefix' => 'dveri'], function () {
    Route::get('/{name}', 'Front@subcat_product');
    Route::get('/', 'Front@categories');
    Route::get('/{category}/{product}', function ($category, $product) {
        return redirect('/dveri/' . $product);
    });
    Route::get('/{category1}/{category2}/{product}', function ($category1, $category2, $product) {
        return redirect('/dveri/' . $product);
    });
    Route::get('/{category1}/{category2}/{product}', function ($category1, $category2, $product) {
        return redirect('/dveri/' . $product);
    });
    Route::get('/{category1}/{category2}/{category3}/{product}', function ($category1, $category2, $product) {
        return redirect('/dveri/' . $product);
    });
});
Route::group(['prefix' => 'furnitura-dvernay'], function () {
    Route::get('/', 'Front@categories');
    Route::get('/{name}', 'Front@subcat_product');
    Route::get('/{category}/{product}', function ($category, $product) {
        return redirect('/furnitura-dvernay/' . $product);
    });
    Route::get('/{category1}/{category2}/{product}', function ($category1, $category2, $product) {
        return redirect('/furnitura-dvernay/' . $product);
    });
});
Route::group(['prefix' => 'dacha-otdih'], function () {
    Route::get('/', 'Front@categories');
    Route::get('/{name}', 'Front@subcat_product');
    Route::get('/{category}/{product}', function ($category, $product) {
        return redirect('/dacha-otdih/' . $product);
    });
    Route::get('/{category1}/{category2}/{product}', function ($category1, $category2, $product) {
        return redirect('/dacha-otdih/' . $product);
    });
});
Route::group(['prefix' => 'laminat-na-pol'], function () {
    Route::get('/', 'Front@categories');
    Route::get('/{name}', 'Front@subcat_product');
    Route::get('/{category}/{product}', function ($category, $product) {
        return redirect('/laminat-na-pol/' . $product);
    });
    Route::get('/{category1}/{category2}/{product}', function ($category1, $category2, $product) {
        return redirect('/laminat-na-pol/' . $product);
    });
});
Route::group(['prefix' => 'dveri-dlja-bani'], function () {
    Route::get('/', 'Front@categories');
    Route::get('/{name}', 'Front@subcat_product');
    Route::get('/{category}/{product}', function ($category, $product) {
        return redirect('/dveri-dlja-bani/' . $product);
    });
    Route::get('/{category1}/{category2}/{product}', function ($category1, $category2, $product) {
        return redirect('/dveri-dlja-bani/' . $product);
    });
});
Route::group(['prefix' => 'dver'], function () {
    Route::get('/{name}', 'Front@blog');
});
Route::get('/rasprodaga', 'Front@rasprogaja');
Route::get('/all-news', 'Front@list_blog');
Route::get('/{name}', 'Front@infopage');
/**
 * admin
 * */
Route::get('/admin', function () {
    return redirect('admin/dashboard');
});

Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {
    //Dashboard Route
    Route::get('dashboard', function () {
        return view('admin.dashboard');
    });
    
    Route::get('/login', function () {
        return redirect('admin/dashboard');
    });
    //EShop Data Entry Routes
    Route::put('/products/create-product-options', 'EShopDataEntry\ProductsController@storeProductOptions');
    Route::put('/products/create', 'EShopDataEntry\ProductsController@store');
    Route::get('/products/edit-product-options/{product}', 'EShopDataEntry\ProductsController@editProductOptions');
    Route::post('/products/update-product-options/{product}', 'EShopDataEntry\ProductsController@updateProductOptions');
    Route::get('/products/search', 'EShopDataEntry\ProductsController@searchProduct');

    Route::resource('brands', 'EShopDataEntry\BrandsController');
    Route::resource('categories', 'EShopDataEntry\CategoriesController');
    Route::resource('products', 'EShopDataEntry\ProductsController');
    Route::resource('options', 'EShopDataEntry\OptionsController');
    Route::resource('values', 'EShopDataEntry\ValuesController');

    Route::post('/products/edit-product-price/{product}', 'EShopDataEntry\ProductsController@changePriceAjax');
    Route::post('/products/edit-product-title/{product}', 'EShopDataEntry\ProductsController@changeTitleAjax');
    Route::post('/products/edit-product-options/{product}', 'EShopDataEntry\ProductsController@changeValueAjax');
    Route::post('/products/create', 'EShopDataEntry\ProductsController@changeValueAjax');
    
    Route::post('/products/edit-brand-sort/{category}', 'EShopDataEntry\BrandsController@changeSortBrandAjax');
    
    //delete
    Route::delete('options', 'EShopDataEntry\OptionsController@destroy');
    Route::delete('products', 'EShopDataEntry\ProductsController@destroy');
    Route::get('product/{id}/delete', 'EShopDataEntry\ProductsController@destroy');
    Route::delete('categories', 'EShopDataEntry\CategoriesController@destroy');
    Route::delete('brands', 'EShopDataEntry\BrandsController@destroy');
    Route::delete('values', 'EShopDataEntry\ValuesController@destroy');
    Route::delete('products/search/{product}', 'EShopDataEntry\ProductsController@destroy');

    //Frontend Data Entry Routes
    Route::resource('blog-posts', 'FrontendDataEntry\BlogPostsController');
    Route::resource('pages', 'FrontendDataEntry\PagesController');
    Route::resource('brand-descriptions', 'FrontendDataEntry\BrandsController');
    Route::resource('informations', 'FrontendDataEntry\InformationsController');
    Route::resource('requests', 'FrontendDataEntry\RequestsController');

    //EShop Transactions Routes
    Route::resource('customers', 'EShopTransactions\CustomersController');
    Route::resource('orders', 'EShopTransactions\OrdersController');
    Route::resource('product-sales', 'EShopTransactions\ProductSalesController');
    Route::resource('order-view/{id}', 'EShopTransactions\OrdersController@show');

    //SEO
    Route::get('positions', 'CollectionPositionController@get');
    Route::get('keys', 'Seo\KeywordsController@getKeys');
    Route::get('error-url', 'Seo\KeywordsController@getUrl');
    Route::get('category-images', 'Seo\ImageOptimizeController@getInfoImageCat');
    Route::get('product-images', 'Seo\ImageOptimizeController@getInfoImageProd');
});