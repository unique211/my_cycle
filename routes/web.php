<?php

use Illuminate\Http\Request;
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


Route::get('/', function () {
    return view('login');
    // return 123;
});

Route::get('/logout', function (Request $request) {
    // $id = $request->session()->get('logs');
    // date_default_timezone_set('Asia/Kolkata');
    // $date = date("Y-m-d H:i:s");
    // DB::table('login_logs')->where('id', $id)->update(['logout_time' => $date]);
    $request->session()->flush();
    return redirect('/');
});

Route::post('login_check', 'LoginController@check_login');

Route::get('firebase', 'FirebaseController@index');
Route::get('sendNotification', 'FirebaseController@sendNotification');

Route::group(['middleware' => 'prevent-back-history'], function () {
    Auth::routes();
    Route::resource('usermanage', 'Usermanagecontroller');




    Route::resource('dashboard', 'Dashboardcontroller');
    Route::get('upcoming_booking_details', 'Dashboardcontroller@upcoming_booking_details');

    Route::resource('language', 'LanguagesController');

    Route::post('get_current_rights/{id}', 'LoginController@get_current_rights');
    Route::post('get_current_rights2/{id}', 'LoginController@get_current_rights2');

    Route::post('change_lang', array(
        'Middleware' => 'LanguageSwitcher',
        'uses' => 'LanguagesController@change_lang'
    ));

    Route::resource('user_access', 'UserAccessController');
    Route::resource('instructor', 'InstructorController');
    Route::resource('member', 'MemberController');

    Route::resource('class_category', 'Class_CategoryController');



    Route::resource('class_booking', 'ClassBookingController');



    Route::resource('attendence_rating', 'AttendenceRatingController');

    Route::resource('inquiry', 'InquiryController');
    Route::get('get_all_inquiry', 'InquiryController@get_all_inquiry');

    Route::resource('mobile_notification', 'MobileNotificationController');
    Route::get('get_all_members', 'MobileNotificationController@get_all_members');
    Route::get('get_all_notifications', 'MobileNotificationController@get_all_notifications');



    Route::resource('member_attendence_taking', 'MemberAttendenceTakingController');
    Route::resource('profile_manager', 'ProfileManagerController');


    //for Pachage Master--Strat
    Route::resource('package', 'PackageController');
    Route::get('get_all', 'PackageController@get_packages');
    Route::get('deletepackage/{id}', 'PackageController@deletepackage');
    Route::get('changestatus/{id}/{status}', 'PackageController@changestatus');
    Route::get('chackpackagename/{packagename}', 'PackageController@chackpackagename');
    Route::get('chackpackagename/{packagename}/{id}', 'PackageController@editchackpackagename');
    //for Pachage Master--End

    //for class Category---Strat
    Route::resource('class_category', 'Class_CategoryController');
    Route::get('checkclasscategory/{catname}', 'Class_CategoryController@checkclasscategory');
    Route::get('checkclasscategory/{catname}/{id}', 'Class_CategoryController@editcheckclasscategory');
    Route::get('getall_classcategory', 'Class_CategoryController@getall_classcategory');
    Route::get('getdesibleall_classcategory', 'Class_CategoryController@getdesibleall_classcategory');
    Route::get('deletecategory/{id}', 'Class_CategoryController@deletecategory');
    Route::get('categorychangestatus/{id}/{status}', 'Class_CategoryController@categorychangestatus');

    //for room maste start--
    Route::resource('room', 'RoomController');
    Route::get('checkroomexist/{room}', 'RoomController@checkroomexist');
    Route::get('checkroomexist/{room}/{id}', 'RoomController@editcheckroomexist');
    Route::get('getallroom', 'RoomController@getallroom');
    Route::get('gethidedelallroom', 'RoomController@gethidedelallroom');

    Route::get('deleteroom/{id}', 'RoomController@deleteroom');
    Route::get('roomchangestatus/{id}/{status}', 'RoomController@roomchangestatus');

    //for class master module
    Route::resource('class', 'ClassController');
    Route::get('getallcategory', 'ClassController@getall_category');
    Route::get('getallclass', 'ClassController@getallclass');
    Route::get('deleteclass/{id}', 'ClassController@deleteclass');
    Route::get('classchangestatus/{id}/{status}', 'ClassController@classchangestatus');
    Route::get('checkclassexist/{classname}', 'ClassController@checkclassexist');
    Route::get('checkclassexist/{classname}/{id}', 'ClassController@editcheckclassexist');

    //for class schedual
    Route::resource('class_schedule', 'ClassScheduleController');
    Route::get('getdropallclass', 'ClassScheduleController@getdropallclass');
    Route::get('getdropallroom', 'ClassScheduleController@getdropallroom');
    Route::get('getdropallinstuctor', 'ClassScheduleController@getdropallinstuctor');
    Route::get('getscedulaclass', 'ClassScheduleController@getscedulaclass');
    Route::get('deleteclasssechedule/{id}', 'ClassScheduleController@deleteclasssechedule');
    Route::get('changeclasssechedulestatus/{id}/{status}', 'ClassScheduleController@changeclasssechedulestatus');

    //for Deal Master
    Route::resource('deals', 'DealsController');
    Route::get('getalldeal', 'DealsController@getalldeal');
    Route::match(['get', 'post'], 'dealuploadimg', 'DealsController@uploadingfile');
    Route::get('checkdealtitle/{title}', 'DealsController@checkdealtitleexist');
    Route::get('checkdealtitle/{title}/{id}', 'DealsController@editcheckdealtitleexist');
    Route::get('deletedeals/{id}', 'DealsController@deletedeals');

    //for Gallery Master
    Route::resource('gallery', 'GalleryController');
    Route::match(['get', 'post'], 'galleryuploadimg', 'GalleryController@galleryuploadimg');
    Route::get('getallgallary/{id}', 'GalleryController@getallgallary');
    Route::get('getallgallary_all_data', 'GalleryController@getallgallary_all_data');
    Route::get('changepostshare/{id}/{status}', 'GalleryController@changepostshare');
    Route::get('deletegallary/{id}', 'GalleryController@deletegallary');

    //for  Profile Manager

    Route::get('get_menu', 'ProfileManagerController@getallmenu');
    Route::get('user_rights/{id}', 'ProfileManagerController@getallmenuright');
    Route::get('get_all_profile', 'ProfileManagerController@get_all_profile');
    Route::post('deleteuserright', 'ProfileManagerController@deleteuserright');
    Route::get('deleteprofile/{id}', 'ProfileManagerController@deleteprofile');
    Route::resource('profile_manager', 'ProfileManagerController');

    //for instructor
    Route::match(['get', 'post'], 'instrucoruploadimg', 'InstructorController@instrucoruploadimg');
    Route::get('getintructorright', 'InstructorController@getintructorright');
    Route::get('checkuserid/{userid}', 'InstructorController@checkuserid');
    Route::post('deleteinstructor', 'InstructorController@deleteinstructorright');
    Route::get('getall_instructor', 'InstructorController@getall_instructor');
    Route::get('geteditintructorright/{id}', 'InstructorController@geteditintructorright');
    Route::get('checkinstuctorname/{name}', 'InstructorController@checkinstuctorname');
    Route::get('deleteallinfoin/{id}', 'InstructorController@deleteallinfoin');

    //for user Access
    Route::get('getallprofileright/{usertype}', 'UserAccessController@getallprofileright');
    Route::get('checkemailaddress/{email}', 'UserAccessController@checkemailaddress');
    Route::get('checkusername/{name}', 'UserAccessController@checkusername');
    Route::get('getall_useraccess', 'UserAccessController@getall_useraccess');
    Route::get('getedituserright/{id}', 'UserAccessController@getedituserright');
    Route::get('deleteuseraccess/{id}', 'UserAccessController@deleteuseraccess');
    //Route::get('useracessrightdel/{id}', 'UserAccessController@useracessrightdel');
    Route::post('useracessrightdel', 'UserAccessController@useracessrightdel');
    Route::get('get_all_profile_data', 'UserAccessController@get_all_profile_data');



    //for Member Type

    Route::resource('member_type', 'MemberTypeController');

    Route::get('getallmemberttype', 'MemberTypeController@getallmemberttype');
    Route::get('chackmemberexist/{name}', 'MemberTypeController@chackmemberexist');
    Route::get('deletemembertype/{id}', 'MemberTypeController@deletemembertype');
    Route::get('checkuserid_member/{userid}', 'MemberTypeController@checkuserid_member');

    //for  Site Setting

    Route::resource('site_setting', 'SiteSettingController');
    Route::get('getallsitesettinginfo', 'SiteSettingController@getallsitesettinginfo');
    Route::get('deletesitesetting/{id}', 'SiteSettingController@deletesitesetting');
    Route::match(['get', 'post'], 'site_map_image_upload', 'SiteSettingController@site_map_image_upload');
    //for Member
    Route::get('getdropdwnallpackage', 'MemberController@getdropdwnallpackage');
    Route::post('getpackagepoint', 'MemberController@getpackagepoint');
    Route::get('getallmember', 'MemberController@getallmember');
    Route::post('deletemembers', 'MemberController@deletemembers');
    Route::post('getgroupwiseinfo', 'MemberController@getgroupwiseinfo');
    Route::get('getpointusage/{id}', 'MemberController@pointusage');
    Route::get('deletememberinfo/{id}', 'MemberController@deletememberinfo');
    Route::get('checkuseridexist/{userid}', 'MemberController@checkuseridexist');
    Route::get('checkuseridexist/{userid}/{id}', 'MemberController@checkedituseridexist');
    Route::match(['get', 'post'], 'member_img', 'MemberController@uploadimg');

    //for member attadance
    Route::post('getbetweenclasssechedule', 'MemberAttendenceTakingController@getbetweenclasssechedule');
    Route::post('getsechedulemember', 'MemberAttendenceTakingController@getsechedulemember');
    Route::get('getallattebdance', 'MemberController@getallattebdance');

    //for attandancereport
    Route::post('getattandancedata', 'AttendenceRatingController@getattandancedata');


});

