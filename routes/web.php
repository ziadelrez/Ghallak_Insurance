<?php

use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('index');
//});
Route::get('/', 'IndexController@index');
Route::get('/cars-collections', 'IndexController@getcarcollections')->name('carscollections');
Route::get('/contact-us', 'IndexController@contactus')->name('contactus');
Route::get('/about-us', 'IndexController@aboutus')->name('aboutus');
Route::get('/branches', 'IndexController@branches')->name('branches');

//
//Route::get('/adminsite', function () {
//    return view('admin.siteadmin.adminsite');
//});


Auth::routes();

Route::group(['prefix' => 'adminpanel', 'as' => 'adminpanel.', 'namespace' => 'AController', 'middleware' => ['auth']], function () {
    Route::resource('dashboard', 'DashboardController');
//    Route::get('/', function () {
//        return view('dashboard');
//    });
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users

//    Route::delete('deleteuser', 'UsersController@deleteuser')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    Route::get('add/{id}','UsersController@create')->name('adduser');
    Route::get('busers/{id}','UsersController@getbrusers')->name('busers');

    Route::post('/acc-status','UsersController@changeAccStatus');
    Route::post('/deleteuser', 'UsersController@deleteuser');

    Route::post('/deleterole', 'RolesController@deleterole');

    Route::post('/deletepermission', 'PermissionsController@deletepermission');


   });

//Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']],function(){
//    Route::get('/dashboard', function () {
//        return view('adminpanel.dashboard');
//    });
    Route::get('/dashboard', 'DashboardController@index');

//    Route::get('/home', 'HomeController@index')->name('home');
  });
        ########  Users Modules Routes
//Route::group(['namespace' => 'AController','middleware' => ['auth','admin']],function(){
//
//    Route::get('/users-list/{id}', 'RoleController@getallbrusers');
//    Route::get('/users-list', 'RoleController@getallusers');
//    Route::get('/useredit/{id}', 'RoleController@getuser');
//    Route::put('/user-edit-info/{id}', 'RoleController@userupdate');
//    Route::get('/userdelete/{id}', 'RoleController@userdelete');
//
////    Route::get('/branch-list', 'RoleController@getallbranchs')->name('branch-list');
//
//});


    ########  Global Definition Routes
Route::group(['namespace' => 'Global_Info','middleware' => ['auth']],function(){

    ########  General Definition Routes
    Route::get('/gdef-list', 'GendefController@index')->name('gdef-list');
    Route::get('/gd-values/{id}', 'GendefController@getgdvalues')->name('General-Definition');


    Route::post('/addgdef/{id}', 'GendefController@store');
    Route::post('/editgdef/{id}', 'GendefController@update');
    Route::post('/deletegd/{id}', 'GendefController@deleteitemgd');

    ########  Branches Definition Routes
    Route::get('/branches-list', 'BranchesController@get_br_location')->name('branches-list');
    Route::post('/addbranch', 'BranchesController@addbranches');
    Route::post('/addNewValue', 'BranchesController@addNewValueGD');
    Route::post('/editbranches/{id}', 'BranchesController@editbranches');
    Route::post('/deletebr', 'BranchesController@deletebr');

    Route::get('/getbrdetails/{id}', 'BranchesController@getbrdetails');

});

########  Pages Routes 'prefix' => 'pages',, 'as' => 'pages.'
Route::group(['namespace' => 'Pages','middleware' => ['auth']],function(){

    ########  Clients
//    Route::get('/clients-list', 'ClientsController@getclients')->name('clients-list');
//    Route::get('/clients-create', 'ClientsController@clientscreate')->name('clients-create');
//
//        Route::resource('clients', 'ClientsController');

###### Clients Section
    Route::get('/clients-list','ClientsController@index')-> name('clients-list');
    Route::get('/clients/create','ClientsController@create')-> name('clients.create');

    Route::get('/clients/edit/{id}','ClientsController@edit')-> name('clients.edit');
    Route::get('/clients/show/{id}','ClientsController@show')-> name('clients.show');
    Route::post('/clients/store','ClientsController@store')-> name('clients.store');
    Route::post('/clients/update/{id}','ClientsController@update')-> name('clients.update');
    Route::post('/deleteclient', 'ClientsController@deleteclient');

    Route::post('/addNewValueDEF', 'ClientsController@addNewValueDEF');

    ######## Add License Clients
    Route::post('/addNewValuePlace', 'ClientsController@addNewValuePlace');

    Route::get('/clients/license/{id}','ClientsController@licenses')-> name('clients.licenses');
    Route::post('/addlicense', 'ClientsController@addlicenses');
    Route::get('/getlicensedetails/{id}', 'ClientsController@getlicensedetails');
    Route::post('/editlicense/{id}', 'ClientsController@editlicense');
    Route::post('/deletelicense/{id}', 'ClientsController@deletelicense');

    ######## Add Documents Clients
    Route::get('/clients/docs/{id}','ClientsController@attachclient')-> name('clients.docs');
    Route::post('/addlicense', 'ClientsController@addlicenses');
    Route::post('/uploadfiles', 'ClientsController@uploadfiles')-> name('clients.attach');
    Route::post('/image_delete_file/{id}', 'ClientsController@image_delete_file');
    Route::post('/savedocfile', 'ClientsController@savedocfile');
    Route::post('/doc_image_delete_file/{id}', 'ClientsController@image_delete_file');
    Route::get('/getdocdetails/{id}', 'ClientsController@getdocdetails');
    Route::post('/editdoc', 'ClientsController@editdoc');
    Route::post('/deletedoc', 'ClientsController@deletedoc');
    Route::get('/print-doc/{id}', 'ClientsController@printdoc')-> name('print.doc');



    ###### Cars Section
    Route::get('/cars-list','CarsController@index')-> name('cars-list');
    Route::get('/cars/create','CarsController@create')-> name('cars.create');
    Route::post('/cars/store','CarsController@store')-> name('cars.store');
    Route::post('/caruploadimg', 'CarsController@caruploadimg')-> name('carsimg.attach');
    Route::post('/car_image_delete_file/{id}', 'CarsController@image_delete_file');
    Route::get('/carsaction', 'CarsController@action');
    Route::get('/cars/edit/{id}','CarsController@edit')-> name('cars.edit');
    Route::post('/deletecars', 'CarsController@deletecars');
    Route::post('/cars/update/{id}','CarsController@update')-> name('cars.update');
    Route::get('/cars/attach/{id}','CarsController@attachimages')-> name('cars.images');

    Route::get('/cars/attach/{id}','CarsController@attachimages')-> name('cars.images');

    Route::post('/upload-images-files', 'CarsController@storeIMAGES');
    Route::post('/upload-docs-files', 'CarsController@storeDOCS');
    Route::get('/download-patient-files/{id}', 'CarsController@downloadFiles');
    Route::post('/deleteFile', 'CarsController@deleteFile');

    Route::post('/getfileslist', 'CarsController@getfileslist');
//
//    Route::get('/clients/edit/{id}','ClientsController@edit')-> name('clients.edit');
//    Route::get('/clients/show/{id}','ClientsController@show')-> name('clients.show');
//    Route::post('/clients/update/{id}','ClientsController@update')-> name('clients.update');
//    Route::post('/deleteclient/{id}', 'ClientsController@deleteclient');
//
    Route::post('/addNewValueDEF_CAR', 'CarsController@addNewValueDEF');
//
//    ######## Add License Clients
//    Route::post('/addNewValuePlace', 'ClientsController@addNewValuePlace');
//
//    Route::get('/clients/license/{id}','ClientsController@licenses')-> name('clients.licenses');
//    Route::post('/addlicense', 'ClientsController@addlicenses');
//    Route::get('/getlicensedetails/{id}', 'ClientsController@getlicensedetails');
//    Route::post('/editlicense/{id}', 'ClientsController@editlicense');
//    Route::post('/deletelicense/{id}', 'ClientsController@deletelicense');


    ###### Contracts Section
    Route::get('/contract-client/{id}','ContractsController@index')-> name('contract-client');
    Route::get('/payment-client/{id}','ContractsController@indexpayments')-> name('payment-client');
//    Route::get('/contract-client','ContractsController@showall')-> name('contracts-client');
    Route::get('/contracts-list','ContractsController@showall')-> name('contracts-list');
    Route::get('/contract-details/{id}','ContractsController@contractdet')-> name('contract-details');
    Route::get('/contract-car-details/create/{id}','ContractsController@create')-> name('contract-car-details.create');
    Route::post('/contract-car-details/store','ContractsController@store')-> name('contract-car-details.store');
    Route::post('/getcarrate', 'ContractsController@getcarrate');
    Route::post('/getpaymentslist', 'ContractsController@getpaymentslist');
    Route::post('/editpayment', 'ContractsController@editpayment');
    Route::post('/storepayment', 'ContractsController@storepayment');
    Route::post('/deletepayment', 'ContractsController@deletepayment');


    Route::get('/contract-car-details/edit/{id}','ContractsController@edit')-> name('contract-car-details.edit');
    Route::post('/contract-car-details/update/{id}','ContractsController@update')-> name('contract-car-details.update');
    Route::post('/contract-car-details/delete/{id}', 'ContractsController@deletedet');
    Route::post('/getcontdetinfo', 'ContractsController@getcontdetinfo');
    Route::post('/updatecontdetinfo', 'ContractsController@updatecontdetinfo');

    Route::post('/addcontract', 'ContractsController@addcontract');
    Route::get('/getcodate/{id}', 'ContractsController@getcodate');
    Route::post('/editcodate/{id}', 'ContractsController@editcodate');
    Route::post('/deletecontract', 'ContractsController@deletecontract');
    Route::post('/getlinum', 'ContractsController@getlinum');
    Route::post('/adddriver', 'ContractsController@adddriver');
    Route::post('/editdriver', 'ContractsController@editdriver');
    Route::post('/deletedriver', 'ContractsController@deletedriver');

    ###### Contracts Section -> Procedures
    Route::get('/contract-procedures/create/{id}','ContractsController@createcontractprocedures')-> name('contract-procedures.create');
    Route::post('/storeaccident','ContractsController@storeaccident');
    Route::post('/addNewValueProcLocation', 'ContractsController@addNewValueProcLocation');
    Route::post('/getaccidentlist', 'ContractsController@getaccidentlist');
    Route::post('/deleteprocedure', 'ContractsController@deleteprocedure');
    Route::post('/editaccident', 'ContractsController@editaccident');

    Route::post('/storespeed','ContractsController@storespeed');
    Route::post('/getspeedlist', 'ContractsController@getspeedlist');
    Route::post('/editspeed', 'ContractsController@editspeed');

    Route::post('/storefailure','ContractsController@storefailure');
    Route::post('/getfailurelist', 'ContractsController@getfailurelist');
    Route::post('/editfailure', 'ContractsController@editfailure');


    #######Settings
    Route::get('/settings', 'SettingsController@index')->name('settings');
    Route::post('/settings/store','SettingsController@store')-> name('settings.store');
    Route::post('/settings/update','SettingsController@update')-> name('settings.update');

    ###### Expenses
    Route::get('/expenses', 'ExpensesController@index')->name('expenses');
    Route::post('/addNewValueexp', 'ExpensesController@addNewValueexp');
    Route::get('/getexplist', 'ExpensesController@getexplist');
    Route::post('/editexp', 'ExpensesController@editexp');
    Route::post('/storeexp', 'ExpensesController@storeexp');
    Route::post('/deleteexp', 'ExpensesController@deleteexp');

    ###### Booking
    Route::get('/bookings-list', 'BookingController@index')->name('bookings-list');
    Route::get('/getbookinglist', 'BookingController@getbookinglist');
    Route::post('/editbooking', 'BookingController@editbooking');
    Route::post('/storebooking', 'BookingController@storebooking');
    Route::post('/deletebooking', 'BookingController@deletebooking');
    Route::post('/booking-status','BookingController@changeBookingStatus');

});


