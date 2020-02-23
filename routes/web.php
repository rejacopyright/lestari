<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// TEST
Route::get('test', 'testController@kueri');

// AUTH
Route::get('admin', 'admin\auth_c@index')->name('loginAdmin');
Route::post('admin/login', 'admin\auth_c@login');
Route::post('admin/register', 'admin\auth_c@register');
Route::get('admin/logout', 'admin\auth_c@logout');
Route::post('user/register', 'user\auth_c@register');
Route::post('user/login', 'user\auth_c@login');
Route::get('user/logout', 'user\auth_c@logout');

// AJAX
Route::get('ajax_search', 'ajax@search');
Route::get('ajax_analytics', 'ajax@analytics');
Route::get('ajax_search_admin', 'ajax@search_admin');
Route::post('ajax_old_password_admin', 'ajax@old_password_admin');
Route::post('ajax_change_password_admin', 'ajax@change_password_admin');
Route::post('ajax_change_profile_admin', 'ajax@change_profile_admin');
Route::get('ajax_ms_select2', 'ajax@ms_select2');
Route::get('ajax_ms_detail', 'ajax@ms_detail');
Route::get('ajax_model_select2', 'ajax@model_select2');
Route::get('ajax_model_detail/{model_id}', 'ajax@model_detail');
Route::get('ajax_spec_detail/{spec_id}', 'ajax@spec_detail');
Route::get('ajax_spec_value/{spec_id}', 'ajax@spec_value');
Route::get('ajax_series_select2', 'ajax@series_select2');
Route::get('ajax_series_haschild_select2', 'ajax@series_haschild_select2');
Route::get('ajax_series_detail/{series_id}', 'ajax@series_detail');
Route::get('ajax_product_select2', 'ajax@product_select2');
Route::get('ajax_product_haschild_select2', 'ajax@product_haschild_select2');
Route::get('ajax_product_detail/{product_id}', 'ajax@product_detail');
Route::get('ajax_series_ishaschild/{series_id}', 'ajax@series_ishaschild');
Route::get('ajax_type_select2', 'ajax@type_select2');
Route::get('ajax_type_detail', 'ajax@type_detail');
Route::get('ajax_brand_select2', 'ajax@brand_select2');
Route::get('ajax_brand_detail', 'ajax@brand_detail');
Route::get('ajax_setting', 'ajax@setting');
Route::get('ajax_news_detail', 'ajax@news_detail');
Route::get('ajax_promo_detail', 'ajax@promo_detail');
Route::get('ajax_contact_email_select2', 'ajax@contact_email_select2');
Route::get('ajax_banner/{banner_id}', 'ajax@banner_detail');


Route::get('/', 'home_c@home');
Route::get('product', 'product_c@product');
Route::get('product/series/{series_id}', 'product_c@series');
Route::get('product/detail/{product_id}', 'product_c@detail');
Route::get('product/spec', 'product_c@spec');
Route::get('product/spec/detail/{spec_id}', 'product_c@spec_detail');
Route::get('privacy', 'home_c@privacy');
Route::get('terms', 'home_c@terms');
Route::get('about', 'home_c@about');
Route::get('contact', 'home_c@contact');
Route::post('contact/submit', 'home_c@contact_submit');
Route::get('news', 'news_c@news');
Route::get('news/{news_id}', 'news_c@news_detail');
Route::get('promo', 'promo_c@promo');
Route::get('promo/{promo_id}', 'promo_c@promo_detail');

Route::group(["prefix" => "admin", "middleware" => "auth:admin"], function(){
  Route::get('dashboard', 'admin\dashboard_c@dashboard');
  // User
  Route::get('profile', 'admin\user_c@profile');
  // Master
  Route::get('product/master/spec', 'admin\product_c@master_spec');
  Route::post('product/master/spec/store', 'admin\product_c@master_spec_store');
  Route::post('product/master/spec/update', 'admin\product_c@master_spec_update');
  Route::post('product/master/spec/delete', 'admin\product_c@master_spec_delete');
  Route::get('master/banner/list', 'admin\product_c@master_banner_list');
  Route::get('master/banner', 'admin\product_c@master_banner');
  Route::post('master/banner/store', 'admin\product_c@master_banner_store');
  Route::post('master/banner/update', 'admin\product_c@master_banner_update');
  Route::post('master/banner/delete', 'admin\product_c@master_banner_delete');
  Route::post('master/banner/switch', 'admin\product_c@master_banner_switch');
  // Product
  Route::get('product', 'admin\product_c@index');
  Route::get('product/add', 'admin\product_c@product_add');
  Route::get('product/edit/{product_id}', 'admin\product_c@product_edit');
  Route::post('product/store', 'admin\product_c@product_store');
  Route::post('product/update', 'admin\product_c@product_update');
  Route::post('product/delete', 'admin\product_c@product_delete');
  // Series
  Route::get('product/series', 'admin\product_c@product_series');
  Route::get('product/series/add', 'admin\product_c@product_series_add');
  Route::get('product/series/edit/{series_id}', 'admin\product_c@product_series_edit');
  Route::post('product/series/store', 'admin\product_c@product_series_store');
  Route::post('product/series/update', 'admin\product_c@product_series_update');
  Route::post('product/series/delete', 'admin\product_c@product_series_delete');
  // Spec
  Route::get('product/spec', 'admin\product_c@product_spec');
  Route::post('product/spec/store', 'admin\product_c@product_spec_store');
  Route::post('product/spec/update', 'admin\product_c@product_spec_update');
  Route::post('product/spec/delete', 'admin\product_c@product_spec_delete');
  Route::post('product/spec/value', 'admin\product_c@product_spec_value');
  // Model
  Route::get('product/model', 'admin\product_c@product_model');
  Route::post('product/model/store', 'admin\product_c@product_model_store');
  Route::post('product/model/update', 'admin\product_c@product_model_update');
  Route::post('product/model/delete', 'admin\product_c@product_model_delete');
  // Type
  Route::get('product/type', 'admin\product_c@type');
  Route::post('product/type/store', 'admin\product_c@type_store');
  Route::post('product/type/update', 'admin\product_c@type_update');
  Route::post('product/type/delete', 'admin\product_c@type_delete');
  // Brand
  Route::get('product/brand', 'admin\product_c@brand');
  Route::post('product/brand/store', 'admin\product_c@brand_store');
  Route::post('product/brand/update', 'admin\product_c@brand_update');
  Route::post('product/brand/delete', 'admin\product_c@brand_delete');
  // Settings
  Route::get('about', 'admin\setting_c@about');
  Route::post('about/update', 'admin\setting_c@about_update');
  Route::get('vision', 'admin\setting_c@vision');
  Route::post('vision/update', 'admin\setting_c@vision_update');
  Route::get('mission', 'admin\setting_c@mission');
  Route::post('mission/update', 'admin\setting_c@mission_update');
  Route::get('company', 'admin\setting_c@company');
  Route::post('company/update', 'admin\setting_c@company_update');
  // News
  Route::get('news', 'admin\news_c@news');
  Route::get('news/add', 'admin\news_c@add');
  Route::post('news/store', 'admin\news_c@store');
  Route::get('news/edit/{news_id}', 'admin\news_c@edit');
  Route::post('news/put', 'admin\news_c@put');
  Route::post('news/delete', 'admin\news_c@delete');
  // Promo
  Route::get('promo', 'admin\promo_c@promo');
  Route::get('promo/add', 'admin\promo_c@add');
  Route::post('promo/store', 'admin\promo_c@store');
  Route::get('promo/edit/{promo_id}', 'admin\promo_c@edit');
  Route::post('promo/put', 'admin\promo_c@put');
  Route::post('promo/delete', 'admin\promo_c@delete');
  // Marketing
  Route::get('marketing', 'admin\marketing_c@marketing');
  Route::get('marketing/contact/email', 'admin\marketing_c@contact_email');
  Route::post('marketing/contact/email/store', 'admin\marketing_c@contact_email_store');
  Route::post('marketing/contact/email/delete', 'admin\marketing_c@contact_email_delete');
  Route::get('marketing/email', 'admin\marketing_c@email');
  Route::post('marketing/email/store', 'admin\marketing_c@email_store');
});

Auth::routes();

Route::get('/home', 'home_c@home')->name('home');
