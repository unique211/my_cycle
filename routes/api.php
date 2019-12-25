<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['basicAuth'])->group(function () {
    //All the routes are placed in here

    ///for Package Api start---
    Route::resource('package', 'PackageController');
    // Route::post('insert', 'PackageController@store');
    Route::get('getallpackage', 'PackageController@get_packages');
    Route::get('getpackage/{id}', 'PackageController@getpackage');
    Route::get('deletepackage/{id}', 'PackageController@deletepackage');

    //for class Category Api Strat------
    Route::resource('class_category', 'Class_CategoryController');
    Route::get('list_date', 'Class_CategoryController@getall_classcategory2');
    Route::get('getsingleclasscategory/{id}', 'Class_CategoryController@getsingleclasscategory');

    //for room master
    Route::resource('room', 'RoomController');
    Route::get('getallroom', 'RoomController@getallroom');
    Route::get('getsingleroom/{id}', 'RoomController@getsingleroom');

    //for class master
    Route::resource('class', 'ClassController');
    Route::get('getallclass', 'ClassController@getallclass');
    Route::get('getsingleclass/{id}', 'ClassController@getsingleclass');

    //for class sechedule
    Route::resource('class_schedule', 'ClassScheduleController');
    Route::get('getscedulaclass', 'ClassScheduleController@getscedulaclass');
    Route::get('getsinglescedulaclass/{id}', 'ClassScheduleController@getsingleclassschedule');

    //for deal
    Route::resource('deals', 'DealsController');
    Route::get('getalldeal', 'DealsController@getalldeal');
    Route::get('getsingledeal/{id}', 'DealsController@getsingledeal');

    //for gallary
    Route::resource('gallery', 'GalleryController');
    Route::get('getallgallary', 'GalleryController@getallgallary');
    Route::get('getsinglegallary/{id}', 'GalleryController@getsingleallgallary');

    //for membertype
    Route::resource('member_type', 'MemberTypeController');
    Route::get('getallmemberttype', 'MemberTypeController@getallmemberttype');
    Route::get('getsinglegmembertype/{id}', 'MemberTypeController@getsinglegmembertype');


    //for login

    Route::post('login_request', 'Usermanagecontroller@login_request');

    //datewise shedule
    Route::post('datewise_shedule', 'ClassScheduleController@datewise_shedule');

    //gallery api
    Route::get('gallery_api', 'GalleryController@gallery_api');

    //deals api
    Route::get('deals_api', 'DealsController@deals_api');

    //booking api
    Route::post('booking_api', 'ClassScheduleController@booking_api');

    //cancel_booking_api
    Route::post('cancel_booking_api', 'ClassScheduleController@cancel_booking_api');

    //rating_api
    Route::post('rating_api', 'ClassScheduleController@rating_api');

    //user_settings
    Route::post('user_settings', 'Usermanagecontroller@user_settings');

    //member_profile
    Route::post('member_profile', 'Usermanagecontroller@member_profile');



    //my_bookings
    Route::post('my_bookings_api', 'ClassScheduleController@my_bookings_api');
    Route::post('class_schedule_details_api', 'ClassScheduleController@my_bookings_details_api');



    //update_member
    Route::post('update_member_api', 'Usermanagecontroller@update_member_api');


    //add_like in gallary
    Route::post('gallery_post_addlike', 'GalleryController@gallery_post_addlike');

    //get site settings
    Route::get('get_site_settings_api', 'SiteSettingController@get_site_settings_api');

    //update user settings
    Route::post('update_user_settings_api', 'Usermanagecontroller@update_user_settings_api');


    //get_notifications_api
    Route::post('get_notifications_api', 'GalleryController@get_notifications_api');

    //delete_notifications_api
    Route::post('delete_notifications_api', 'GalleryController@delete_notifications_api');


    //email_api
    Route::post('email_api', 'ClassScheduleController@email_api');
});
Route::post('send_reminder', 'ClassScheduleController@send_reminder');
