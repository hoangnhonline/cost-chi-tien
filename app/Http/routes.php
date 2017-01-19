<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', ['as' => 'login-form', 'uses' => 'UserController@loginForm']);
Route::post('/', ['as' => 'check-login', 'uses' => 'UserController@checkLogin']);
Route::get('/logout', ['as' => 'logout', 'uses' => 'UserController@logout']);
Route::group(['prefix' => 'account'], function () {
    Route::get('/', ['as' => 'account.index', 'uses' => 'AccountController@index']);
    Route::get('/change-password', ['as' => 'account.change-pass', 'uses' => 'AccountController@changePass']);
    Route::post('/store-password', ['as' => 'account.store-pass', 'uses' => 'AccountController@storeNewPass']);
    Route::get('/update-status/{status}/{id}', ['as' => 'account.update-status', 'uses' => 'AccountController@updateStatus']);
    Route::get('/create', ['as' => 'account.create', 'uses' => 'AccountController@create']);
    Route::post('/store', ['as' => 'account.store', 'uses' => 'AccountController@store']);
    Route::get('{id}/edit',   ['as' => 'account.edit', 'uses' => 'AccountController@edit']);
    Route::post('/update', ['as' => 'account.update', 'uses' => 'AccountController@update']);
    Route::get('{id}/destroy', ['as' => 'account.destroy', 'uses' => 'AccountController@destroy']);
    Route::get('/ajax-list', ['as' => 'account.ajax-list', 'uses' => 'AccountController@ajaxList']);
});
Route::group(['prefix' => 'compare'], function () {
    Route::get('/', ['as' => 'compare.index', 'uses' => 'CompareController@index']);
});
Route::group(['prefix' => 'settings'], function () {
    Route::get('/', ['as' => 'settings.index', 'uses' => 'SettingsController@index']);
    Route::post('/update', ['as' => 'settings.update', 'uses' => 'SettingsController@update']);
});
Route::group(['prefix' => 'report'], function () {
    Route::get('/', ['as' => 'report.index', 'uses' => 'ReportController@index']);     
    Route::post('/search-price-other-site', ['as' => 'crawler.search-price-other-site', 'uses' => 'CompareController@search']);
});

Route::group(['prefix' => 'cost'], function () {
    Route::get('/', ['as' => 'cost.index', 'uses' => 'CostController@index']);
    Route::get('/create', ['as' => 'cost.create', 'uses' => 'CostController@create']);
    Route::post('/store', ['as' => 'cost.store', 'uses' => 'CostController@store']);
    Route::get('{id}/edit',   ['as' => 'cost.edit', 'uses' => 'CostController@edit']);
    Route::post('/update', ['as' => 'cost.update', 'uses' => 'CostController@update']);
    Route::get('{id}/destroy', ['as' => 'cost.destroy', 'uses' => 'CostController@destroy']);
});
Route::group(['prefix' => 'department'], function () {
    Route::get('/ajax-list', ['as' => 'department.ajax-list', 'uses' => 'DepartmentController@ajaxList']);
    Route::get('/create', ['as' => 'cost.create', 'uses' => 'CostController@create']);
    Route::post('/store', ['as' => 'cost.store', 'uses' => 'CostController@store']);
    Route::get('{id}/edit',   ['as' => 'cost.edit', 'uses' => 'CostController@edit']);
    Route::post('/update', ['as' => 'cost.update', 'uses' => 'CostController@update']);
    Route::get('{id}/destroy', ['as' => 'cost.destroy', 'uses' => 'CostController@destroy']);
});
Route::group(['prefix' => 'color'], function () {
    Route::get('/', ['as' => 'color.index', 'uses' => 'ColorController@index']);
    Route::get('/create', ['as' => 'color.create', 'uses' => 'ColorController@create']);
    Route::post('/store', ['as' => 'color.store', 'uses' => 'ColorController@store']);
    Route::get('{id}/edit',   ['as' => 'color.edit', 'uses' => 'ColorController@edit']);
    Route::post('/update', ['as' => 'color.update', 'uses' => 'ColorController@update']);
    Route::get('{id}/destroy', ['as' => 'color.destroy', 'uses' => 'ColorController@destroy']);
});
Route::group(['prefix' => 'customernoti'], function () {
    Route::get('/', ['as' => 'customernoti.index', 'uses' => 'CustomerNotificationController@index']);
    Route::get('/create', ['as' => 'customernoti.create', 'uses' => 'CustomerNotificationController@create']);
    Route::post('/store', ['as' => 'customernoti.store', 'uses' => 'CustomerNotificationController@store']);
    Route::get('{id}/edit',   ['as' => 'customernoti.edit', 'uses' => 'CustomerNotificationController@edit']);
    Route::post('/update', ['as' => 'customernoti.update', 'uses' => 'CustomerNotificationController@update']);
    Route::get('{id}/destroy', ['as' => 'customernoti.destroy', 'uses' => 'CustomerNotificationController@destroy']);
});
Route::group(['prefix' => 'bill'], function () {
    Route::get('/', ['as' => 'bill.index', 'uses' => 'BillController@index']);
    Route::get('/create', ['as' => 'bill.create', 'uses' => 'BillController@create']);
    Route::post('/store', ['as' => 'bill.store', 'uses' => 'BillController@store']);
    Route::get('{id}/edit',   ['as' => 'bill.edit', 'uses' => 'BillController@edit']);
    Route::post('/update', ['as' => 'bill.update', 'uses' => 'BillController@update']);
    Route::get('{id}/destroy', ['as' => 'bill.destroy', 'uses' => 'BillController@destroy']);
});
Route::group(['prefix' => 'bill-detail'], function () {
    Route::get('/', ['as' => 'bill-detail.index', 'uses' => 'BillDetailController@index']);
    Route::get('/create', ['as' => 'bill-detail.create', 'uses' => 'BillDetailController@create']);
    Route::post('/store', ['as' => 'bill-detail.store', 'uses' => 'BillDetailController@store']);
    Route::get('{id}/edit',   ['as' => 'bill-detail.edit', 'uses' => 'BillDetailController@edit']);
    Route::post('/update', ['as' => 'bill-detail.update', 'uses' => 'BillDetailController@update']);
    Route::get('{id}/destroy', ['as' => 'bill-detail.destroy', 'uses' => 'BillDetailController@destroy']);
});
Route::group(['prefix' => 'customer'], function () {
    Route::get('/', ['as' => 'customer.index', 'uses' => 'CustomerController@index']);
    Route::post('/store', ['as' => 'customer.store', 'uses' => 'CustomerController@store']);
    Route::get('/create', ['as' => 'customer.create', 'uses' => 'CustomerController@create']);
    Route::get('{id}/edit',   ['as' => 'customer.edit', 'uses' => 'CustomerController@edit']);
    Route::get('/export',   ['as' => 'customer.export', 'uses' => 'CustomerController@download']);
    Route::post('/update', ['as' => 'customer.update', 'uses' => 'CustomerController@update']);
    Route::get('{id}/destroy', ['as' => 'customer.destroy', 'uses' => 'CustomerController@destroy']);
    Route::get('/update-status/{status}/{id}', ['as' => 'customer.update-status', 'uses' => 'CustomerController@updateStatus']);
});
Route::group(['prefix' => 'contact'], function () {
    Route::get('/', ['as' => 'contact.index', 'uses' => 'ContactController@index']);
    Route::post('/store', ['as' => 'contact.store', 'uses' => 'ContactController@store']);
    Route::get('{id}/edit',   ['as' => 'contact.edit', 'uses' => 'ContactController@edit']);
    Route::get('/export',   ['as' => 'contact.export', 'uses' => 'ContactController@download']);
    Route::post('/update', ['as' => 'contact.update', 'uses' => 'ContactController@update']);
    Route::get('{id}/destroy', ['as' => 'contact.destroy', 'uses' => 'ContactController@destroy']);
});
Route::group(['prefix' => 'events'], function () {
    Route::get('/', ['as' => 'events.index', 'uses' => 'EventsController@index']);
    Route::get('/create', ['as' => 'events.create', 'uses' => 'EventsController@create']);
    Route::post('/store', ['as' => 'events.store', 'uses' => 'EventsController@store']);
    Route::get('{id}/edit',   ['as' => 'events.edit', 'uses' => 'EventsController@edit']);
    Route::post('/update', ['as' => 'events.update', 'uses' => 'EventsController@update']);
    Route::get('{id}/destroy', ['as' => 'events.destroy', 'uses' => 'EventsController@destroy']);
    Route::get('destroy-product/{event_id}/{sp_id}', ['as' => 'events.destroy-product', 'uses' => 'EventsController@destroyProduct']);
    Route::get('/product-event/{event_id}', ['as' => 'events.product-event', 'uses' => 'EventsController@productEvent']);
    Route::post('/ajax-search', ['as' => 'events.ajax-search', 'uses' => 'EventsController@ajaxSearch']);
    Route::post('/ajax-save-product', ['as' => 'events.ajax-save-product', 'uses' => 'EventsController@ajaxSaveProduct']);
});
Route::group(['prefix' => 'tinh'], function () {
    Route::get('/', ['as' => 'tinh.index', 'uses' => 'TinhThanhController@index']);
    Route::post('/store', ['as' => 'tinh.store', 'uses' => 'TinhThanhController@store']);
    Route::get('{id}/edit',   ['as' => 'tinh.edit', 'uses' => 'TinhThanhController@edit']);
    Route::post('/update', ['as' => 'tinh.update', 'uses' => 'TinhThanhController@update']);
    Route::get('{id}/destroy', ['as' => 'tinh.destroy', 'uses' => 'TinhThanhController@destroy']);
});
Route::group(['prefix' => 'loai-sp'], function () {
    Route::get('/', ['as' => 'loai-sp.index', 'uses' => 'LoaiSpController@index']);
    Route::get('/create', ['as' => 'loai-sp.create', 'uses' => 'LoaiSpController@create']);
    Route::get('/thuoc-tinh', ['as' => 'loai-sp.thuoc-tinh', 'uses' => 'LoaiSpController@thuocTinh']);
    Route::get('/edit-thuoc-tinh', ['as' => 'loai-sp.edit-thuoc-tinh', 'uses' => 'LoaiSpController@editThuocTinh']);
    Route::get('/list-thuoc-tinh', ['as' => 'loai-sp.list-thuoc-tinh', 'uses' => 'LoaiSpController@listThuocTinh']);
    Route::post('/store-thuoc-tinh', ['as' => 'loai-sp.store-thuoc-tinh', 'uses' => 'LoaiSpController@storeThuocTinh']);
    Route::post('/update-thuoc-tinh', ['as' => 'loai-sp.update-thuoc-tinh', 'uses' => 'LoaiSpController@updateThuocTinh']);
    Route::post('/store', ['as' => 'loai-sp.store', 'uses' => 'LoaiSpController@store']);
    Route::get('{id}/edit',   ['as' => 'loai-sp.edit', 'uses' => 'LoaiSpController@edit']);
    Route::post('/update', ['as' => 'loai-sp.update', 'uses' => 'LoaiSpController@update']);
    Route::get('{id}/destroy', ['as' => 'loai-sp.destroy', 'uses' => 'LoaiSpController@destroy']);
    Route::get('{id}/destroy-thuoc-tinh', ['as' => 'loai-sp.destroyThuocTinh', 'uses' => 'LoaiSpController@destroyThuocTinh']);
});
Route::group(['prefix' => 'convert'], function () {
    Route::get('/', ['as' => 'convert.index', 'uses' => 'ConvertController@index']);
});
Route::group(['prefix' => 'loai-thuoc-tinh'], function () {
    Route::get('/', ['as' => 'loai-thuoc-tinh.index', 'uses' => 'LoaiThuocTinhController@index']);
    Route::get('/create', ['as' => 'loai-thuoc-tinh.create', 'uses' => 'LoaiThuocTinhController@create']);
    Route::post('/store', ['as' => 'loai-thuoc-tinh.store', 'uses' => 'LoaiThuocTinhController@store']);

    Route::get('{id}/edit',   ['as' => 'loai-thuoc-tinh.edit', 'uses' => 'LoaiThuocTinhController@edit']);
    Route::post('/update', ['as' => 'loai-thuoc-tinh.update', 'uses' => 'LoaiThuocTinhController@update']);
    Route::get('{id}/destroy', ['as' => 'loai-thuoc-tinh.destroy', 'uses' => 'LoaiThuocTinhController@destroy']);
    Route::get('/ajax-get-loai-thuoc-tinh-by-id', ['as' => 'loai-thuoc-tinh.ajax-get-loai-thuoc-tinh-by-id', 'uses' => 'LoaiThuocTinhController@getLoaiThuocTinhByLoaiId']);
});
Route::group(['prefix' => 'thuoc-tinh'], function () {
    Route::get('/', ['as' => 'thuoc-tinh.index', 'uses' => 'ThuocTinhController@index']);
    Route::get('/create', ['as' => 'thuoc-tinh.create', 'uses' => 'ThuocTinhController@create']);
    Route::post('/store', ['as' => 'thuoc-tinh.store', 'uses' => 'ThuocTinhController@store']);
    Route::get('{id}/edit',   ['as' => 'thuoc-tinh.edit', 'uses' => 'ThuocTinhController@edit']);
    Route::post('/update', ['as' => 'thuoc-tinh.update', 'uses' => 'ThuocTinhController@update']);
    Route::get('{id}/destroy', ['as' => 'thuoc-tinh.destroy', 'uses' => 'ThuocTinhController@destroy']);
});
Route::group(['prefix' => 'cate'], function () {
    Route::get('/{loai_id?}', ['as' => 'cate.index', 'uses' => 'CateController@index']);
    Route::get('/create/{loai_id?}', ['as' => 'cate.create', 'uses' => 'CateController@create']);
    Route::post('/store', ['as' => 'cate.store', 'uses' => 'CateController@store']);
    Route::get('{id}/edit',   ['as' => 'cate.edit', 'uses' => 'CateController@edit']);
    Route::post('/update', ['as' => 'cate.update', 'uses' => 'CateController@update']);
    Route::get('{id}/destroy', ['as' => 'cate.destroy', 'uses' => 'CateController@destroy']);
});
Route::group(['prefix' => 'banner'], function () {
    Route::get('/', ['as' => 'banner.index', 'uses' => 'BannerController@index']);
    Route::get('/create/', ['as' => 'banner.create', 'uses' => 'BannerController@create']);
    Route::get('/list', ['as' => 'banner.list', 'uses' => 'BannerController@list']);
    Route::post('/store', ['as' => 'banner.store', 'uses' => 'BannerController@store']);
    Route::get('/edit',   ['as' => 'banner.edit', 'uses' => 'BannerController@edit']);
    Route::post('/update', ['as' => 'banner.update', 'uses' => 'BannerController@update']);
    Route::get('{id}/destroy', ['as' => 'banner.destroy', 'uses' => 'BannerController@destroy']);
});
Route::group(['prefix' => 'product'], function () {
    Route::get('/', ['as' => 'product.index', 'uses' => 'ProductController@index']);
    Route::get('/short', ['as' => 'product.short', 'uses' => 'ProductController@short']);
    Route::get('/ajax-get-detail-product', ['as' => 'ajax-get-detail-product', 'uses' => 'ProductController@ajaxDetail']);        
    Route::get('/create/', ['as' => 'product.create', 'uses' => 'ProductController@create']);
    Route::get('/tuong-thich', ['as' => 'product.tuong-thich', 'uses' => 'ProductController@spTuongThich']);
    Route::post('/store', ['as' => 'product.store', 'uses' => 'ProductController@store']);
    Route::post('/ajax-save-info', ['as' => 'product.ajax-save-info', 'uses' => 'ProductController@ajaxSaveInfo']);
    Route::get('{id}/edit',   ['as' => 'product.edit', 'uses' => 'ProductController@edit']);
    Route::post('/update', ['as' => 'product.update', 'uses' => 'ProductController@update']);
    Route::post('/ajax-search', ['as' => 'product.ajax-search', 'uses' => 'ProductController@ajaxSearch']);
    Route::post('/ajax-search-tuong-thich', ['as' => 'product.ajax-search-tuong-thich', 'uses' => 'ProductController@ajaxSearchTuongThich']);
    Route::get('{id}/destroy', ['as' => 'product.destroy', 'uses' => 'ProductController@destroy']);
    Route::post('/ajax-save-related', ['as' => 'product.ajax-save-related', 'uses' => 'ProductController@ajaxSaveRelated']);
    Route::post('/ajax-save-tuong-thich', ['as' => 'product.ajax-save-tuong-thich', 'uses' => 'ProductController@ajaxSaveTuongThich']);        
    Route::post('/save-sp-tuong-thich', ['as' => 'product.save-sp-tuong-thich', 'uses' => 'ProductController@saveSpTuongThich']);        

});
Route::post('/tmp-upload', ['as' => 'image.tmp-upload', 'uses' => 'UploadController@tmpUpload']);
Route::post('/tmp-upload-multiple', ['as' => 'image.tmp-upload-multiple', 'uses' => 'UploadController@tmpUploadMultiple']);
Route::post('/update-order', ['as' => 'update-order', 'uses' => 'GeneralController@updateOrder']);
Route::post('/ck-upload', ['as' => 'ck-upload', 'uses' => 'UploadController@ckUpload']);
Route::post('/get-slug', ['as' => 'get-slug', 'uses' => 'GeneralController@getSlug']);

Route::group(['prefix' => 'order'], function () {
    Route::get('/', ['as' => 'orders.index', 'uses' => 'OrderController@index']);
    Route::post('/update', ['as' => 'orders.update', 'uses' => 'OrderController@update']);
    Route::get('/{order_id}/chi-tiet', ['as' => 'order.detail', 'uses' => 'OrderController@orderDetail']);
    Route::post('/delete-order-detail', ['as' => 'order.detail.delete', 'uses' => 'OrderController@orderDetailDelete']);
});

 Route::group(['prefix' => 'articles-cate'], function () {
    Route::get('/', ['as' => 'articles-cate.index', 'uses' => 'ArticlesCateController@index']);
    Route::get('/create', ['as' => 'articles-cate.create', 'uses' => 'ArticlesCateController@create']);
    Route::post('/store', ['as' => 'articles-cate.store', 'uses' => 'ArticlesCateController@store']);
    Route::get('{id}/edit',   ['as' => 'articles-cate.edit', 'uses' => 'ArticlesCateController@edit']);
    Route::post('/update', ['as' => 'articles-cate.update', 'uses' => 'ArticlesCateController@update']);
    Route::get('{id}/destroy', ['as' => 'articles-cate.destroy', 'uses' => 'ArticlesCateController@destroy']);
});
Route::group(['prefix' => 'tag'], function () {
    Route::get('/', ['as' => 'tag.index', 'uses' => 'TagController@index']);
    Route::get('/create', ['as' => 'tag.create', 'uses' => 'TagController@create']);
    Route::post('/store', ['as' => 'tag.store', 'uses' => 'TagController@store']);
    Route::get('{id}/edit',   ['as' => 'tag.edit', 'uses' => 'TagController@edit']);
    Route::post('/update', ['as' => 'tag.update', 'uses' => 'TagController@update']);
    Route::get('{id}/destroy', ['as' => 'tag.destroy', 'uses' => 'TagController@destroy']);
});

Route::group(['prefix' => 'articles'], function () {
    Route::get('/', ['as' => 'articles.index', 'uses' => 'ArticlesController@index']);
    Route::get('/create', ['as' => 'articles.create', 'uses' => 'ArticlesController@create']);
    Route::post('/store', ['as' => 'articles.store', 'uses' => 'ArticlesController@store']);
    Route::get('{id}/edit',   ['as' => 'articles.edit', 'uses' => 'ArticlesController@edit']);
    Route::post('/update', ['as' => 'articles.update', 'uses' => 'ArticlesController@update']);
    Route::get('{id}/destroy', ['as' => 'articles.destroy', 'uses' => 'ArticlesController@destroy']);
});