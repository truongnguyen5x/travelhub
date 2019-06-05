<?php

Route::get('register', 'LoginController@getRegister');
Route::post('register', 'LoginController@postRegister');
Route::get('login', 'LoginController@getLogin');
Route::post('login', 'LoginController@postLogin');
Route::get('/', function () {
    return view('welcome');
});

Route::middleware('LoginMiddleware')->group(function () {
    Route::get('logout', 'LoginController@getLogout');
    Route::get('/plan/add', 'PlanController@getAdd');
    Route::post('/plan/add', 'PlanController@postAdd');
    Route::get('/plan/edit/{id}', 'PlanController@getEdit');
    Route::post('/plan/edit/{id}', 'PlanController@postEdit');
    Route::get('plan/detail/{id}', 'PlanController@getDetail');
    Route::get('plan/delete/{id}', 'PlanController@deletePlan');

    Route::post('join', 'DetailPlanController@joinPlan');
    Route::post('follow', 'DetailPlanController@followPlan');
    Route::post('loadList', 'DetailPlanController@loadList');
    Route::post('process/request', 'DetailPlanController@processRequest');
    Route::post('comment', 'DetailPlanController@postComment');
    Route::post('delete/comment', 'DetailPlanController@deleteComment');

    Route::get('profile/edit', 'ProfileController@getEditProfile');
    Route::post('profile/edit', 'ProfileController@postEditProfile');


    Route::get('trang-chu', 'HomeController@getHomepage');
    Route::get('trang-chu/ke-hoach-moi-nhat', 'HomeController@getHomeNew');
    Route::get('trang-chu/thanh-vien-moi', 'HomeController@getNumber');
    Route::get('trang-chu/noi-bat', 'HomeController@getHomeAttention');
    Route::get('thong-tin-ca-nhan/{id}', 'InforController@getInformation');

    Route::get('trang-ca-nhan/ke-hoach-cua-toi/{id}', 'InforController@getInfor_Myplan');
    Route::get('trang-ca-nhan/ke-hoach-tham-gia/{id}', 'InforController@getInfor_Accede');
    Route::get('trang-ca-nhan/ke-hoach-theo-doi/{id}', 'InforController@getInfor_Follow');

});

Route::get('test1', function () {
    return view('information_myplan');
});
Route::get('testml', function () {
    return view('test');
});

Route::view('test', 'header');
