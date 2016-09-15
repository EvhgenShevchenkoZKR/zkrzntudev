<?php

//TODO add important or not to admin_index of news
//TODO rebuild sliders reorder page to use ajax on reordering

//Rebuild sorting of sliders compleatly

Route::get('ass', function(){
   return 'Fat ass';
});


//Route::group(['prefix' => 'laravel-filemanager' , 'middleware' => 'web' ], function() {
//  Route::get('/', function () {
//    return view('vendor.laravel-filemanager.myindex');
//  });
//});

Route::get('administration', 'IndexController@administrationPage');
Route::get('objava', 'IndexController@showObjavas');
Route::get('news', 'IndexController@showNews');
Route::get('tag/{slug}', 'IndexController@showTag');
Route::get('news/{slug}', 'IndexController@showSingleNews');
Route::get('child/{slug}', 'IndexController@showSingleChild');
Route::post('ajax-more', 'IndexController@ajax_more');
Route::post('ajax-more-parent', 'IndexController@ajax_more_parent');
Route::get('objava/{slug}', 'IndexController@showSingleObjava');

Route::get('tags', 'TagController@index');
Route::post('tags/add', 'TagController@store');
Route::get('adm/tags', 'TagController@adminIndex');
Route::get('adm/tags/add', 'TagController@create');
Route::post('tag/{tag}/edit', 'TagController@update');
Route::get('tag/{tag}/edit', 'TagController@edit');
Route::delete('tag/{tag}/delete', 'TagController@delete');



Route::get('/', 'HomepageController@homepageSlider');
Route::get('owl', 'SliderController@show');

Route::post('sliders', 'SliderController@reindex');
Route::get('sliders', 'SliderController@index');

Route::post('create-slider', 'SliderController@storeSlider');
Route::get('adm/slider/add', 'SliderController@createSlider');

Route::post('edit-slider/{slider}', 'SliderController@storeUpdatedSlider');
Route::get('edit-slider/{slider}', 'SliderController@editSlider');

Route::get('card/{card}', 'CardController@show');

Route::post('cards', 'CardController@store');
Route::get('cards', 'CardController@index');

Route::post('menu-add', 'MenuController@store');

Route::post('ajax-menus-reorder', 'MenuController@reorder_ajax');

Route::post('menus-list', 'MenuController@reindex');
Route::get('menus-list', 'MenuController@menusList');

//Route::get('news', 'NewsController@index');
//Route::get('news/{news}', 'NewsController@show');
//Route::get('news/{slug}', 'NewsController@show');
Route::post('news/add', 'NewsController@store');
Route::get('adm/news/add', 'NewsController@create');
Route::get('adm/news', 'NewsController@adminIndex');

Route::post('adm/news/{news}/edit', 'NewsController@update');
Route::get('adm/news/{news}/edit', 'NewsController@edit');
Route::get('adm/news/{news}/publish', 'NewsController@publish');
Route::get('adm/news/{news}/unpublish', 'NewsController@unpublish');
Route::delete('news/{news}/delete', 'NewsController@delete');


Route::get('adm/quotes', 'QuoteController@adminIndex');
Route::post('adm/quote/add', 'QuoteController@store');
Route::get('adm/quote/add', 'QuoteController@create');
Route::patch('adm/quote/{quote}/edit', 'QuoteController@update');
Route::get('adm/quote/{quote}/edit', 'QuoteController@edit');
Route::delete('adm/quote/{quote}/delete', 'QuoteController@delete');

Route::get('adm/objavas', 'AdvertController@adminIndex');
Route::post('adm/objava/add', 'AdvertController@store');
Route::get('adm/objava/add', 'AdvertController@create');
Route::patch('adm/objava/{advert}/edit', 'AdvertController@update');
Route::get('adm/objava/{advert}/edit', 'AdvertController@edit');
Route::get('adm/objava/{advert}/publish', 'AdvertController@publish');
Route::get('adm/objava/{advert}/unpublish', 'AdvertController@unpublish');
Route::delete('adm/objava/{advert}/delete', 'AdvertController@delete');

Route::get('adm/employees', 'EmployeeController@adminIndex');
Route::post('adm/employee/add', 'EmployeeController@store');
Route::get('adm/employee/add', 'EmployeeController@create');
Route::patch('adm/employee/{employee}/edit', 'EmployeeController@update');
Route::get('adm/employee/{employee}/edit', 'EmployeeController@edit');
Route::delete('adm/employee/{employee}/delete', 'EmployeeController@delete');
Route::post('ajax-employees-reorder', 'EmployeeController@ajax_reorder');


Route::get('adm/links', 'LinkController@adminIndex');
Route::post('adm/link/add', 'LinkController@store');
Route::get('adm/link/add', 'LinkController@create');
Route::patch('adm/link/{link}/edit', 'LinkController@update');
Route::get('adm/link/{link}/edit', 'LinkController@edit');
Route::delete('adm/link/{link}/delete', 'LinkController@delete');
Route::post('ajax-links-reorder', 'LinkController@ajax_reorder');
Route::get('adm/link/{link}/publish', 'LinkController@publish');
Route::get('adm/link/{link}/unpublish', 'LinkController@unpublish');

Route::get('adm/parents', 'ParentPageController@adminIndex');
Route::post('adm/parent/add', 'ParentPageController@store');
Route::get('adm/parent/add', 'ParentPageController@create');
Route::patch('adm/parent/{parent}/edit', 'ParentPageController@update');
Route::get('adm/parent/{parent}/edit', 'ParentPageController@edit');
Route::delete('adm/parent/{parent}/delete', 'ParentPageController@delete');
Route::get('adm/parent/{parent}/publish', 'ParentPageController@publish');
Route::get('adm/parent/{parent}/unpublish', 'ParentPageController@unpublish');

Route::get('adm/childs', 'ChildPageController@adminIndex');
Route::post('adm/child/add', 'ChildPageController@store');
Route::get('adm/child/add', 'ChildPageController@create');
Route::patch('adm/child/{child}/edit', 'ChildPageController@update');
Route::get('adm/child/{child}/edit', 'ChildPageController@edit');
Route::delete('adm/child/{child}/delete', 'ChildPageController@delete');
Route::get('adm/child/{child}/publish', 'ChildPageController@publish');
Route::get('adm/child/{child}/unpublish', 'ChildPageController@unpublish');

Route::get('adm/massonrys', 'MassonryController@adminIndex');
Route::post('adm/massonry/add', 'MassonryController@store');
Route::get('adm/massonry/add', 'MassonryController@create');
Route::patch('adm/massonry/{massonry}/edit', 'MassonryController@update');
Route::get('adm/massonry/{massonry}/edit', 'MassonryController@edit');
Route::delete('adm/massonry/{massonry}/delete', 'MassonryController@delete');
Route::post('ajax-massonry-reorder', 'MassonryController@ajax_reorder');
Route::get('adm/massonry/{massonry}/publish', 'MassonryController@publish');
Route::get('adm/massonry/{massonry}/unpublish', 'MassonryController@unpublish');

//Route::auth();

// Authentication Routes...
$this->get('login', 'Auth\AuthController@showLoginForm');
$this->post('login', 'Auth\AuthController@login');
$this->get('logout', 'Auth\AuthController@logout');

// Registration Routes...
//$this->get('register', 'Auth\AuthController@showRegistrationForm');
//$this->post('register', 'Auth\AuthController@register');

// Password Reset Routes...
$this->get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
$this->post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
$this->post('password/reset', 'Auth\PasswordController@reset');

Route::get('/{slug}', 'IndexController@showParentPage');

//todo - DONE it would be cool to have some ajax reaction on reorder of menus, without clicking on button 
//but it`s not necesseraly
//todo - DONE make all js for ajax call in needed view
//todo - DONE make some function to work with serialized data on backend
//todo - DONE remake all because we do not need html form for this anymore - just JS submit
//todo - DONE get some normal token source
//todo - DONE make success message!

//TODO - DONE when we delete menu - we lose all submenus of it!!! that`s BAD SET some didfferent parent for this