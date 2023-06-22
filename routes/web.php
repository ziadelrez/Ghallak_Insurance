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
Route::get('/', 'IndexController@index')->name('index');
Route::get('/cars-collections', 'IndexController@getcarcollections')->name('carscollections');
Route::get('/contact-us', 'IndexController@contactus')->name('contactus');
Route::get('/about-us', 'IndexController@aboutus')->name('aboutus');
Route::get('/insurancellist', 'IndexController@insurancellist')->name('insurancellist');

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
//    Route::get('users/{id}/useredit','UsersController@useredit')->name('users.useredit');
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


    ########  Insurance List Definition Routes
    Route::get('/insurance-list', 'InsTypeController@get_ins_type')->name('insurances-list');
    Route::post('/addinsname', 'InsTypeController@addinsname');
    Route::post('/addNewValue', 'InsTypeController@addNewValueGD');
    Route::post('/editinsname/{id}', 'InsTypeController@editinsname');
    Route::post('/deleteinsname', 'InsTypeController@deleteinsname');

    Route::get('/getinsdetails/{id}', 'InsTypeController@getinsdetails');


    ########  Companies List Definition Routes
    Route::get('/companies-list', 'CompaniesController@getcompanies')->name('companies-list');
    Route::post('/addcompany', 'CompaniesController@addcompany');
    Route::post('/addNewValue', 'CompaniesController@addNewValueGD');
    Route::post('/editcompany/{id}', 'CompaniesController@editcompany');
    Route::post('/deletecompany', 'CompaniesController@deletecompany');

    Route::get('/getcompanydetails/{id}', 'CompaniesController@getcompanydetails');


    ########  Insurance Of Companies List Definition Routes
    Route::get('/companies-insurance-list/{id}', 'CompaniesController@getcompaniesins')->name('companies.plans.list');
    Route::post('/addcompanyins', 'CompaniesController@addcompanyins');
    Route::post('/addNewValueDEFINS', 'CompaniesController@addNewValueDEF');
    Route::post('/editcompanyins', 'CompaniesController@editcompanyins');
    Route::post('/deletecompanyins', 'CompaniesController@deletecompanyins');

    Route::get('/getcompanydetailsins', 'CompaniesController@getcompanydetailsins');

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
    Route::get('/fecthdataclients','ClientsController@fecthdataclients');
    Route::get('/clients/create','ClientsController@create')-> name('clients.create');
    Route::post('/clients/store','ClientsController@store')-> name('clients.store');
    Route::get('/clients/edit/{id}','ClientsController@edit')-> name('clients.edit');
    Route::get('/clients/show/{id}','ClientsController@show')-> name('clients.show');
    Route::post('/clients/update/{id}','ClientsController@update')-> name('clients.update');
    Route::post('/deleteclient', 'ClientsController@deleteclient');

    Route::get('/clients/maids/{id}','ClientsController@showmaids')-> name('clients.showmaids');
    Route::get('/clients/maids/create/{id}','ClientsController@createmaids')-> name('maids.create');
    Route::post('/deletemaids', 'ClientsController@deletemaids');
    Route::get('/clientsmaidsaction', 'ClientsController@actionclientsmaids');
    Route::post('/clients/maids/store','ClientsController@storemaids')-> name('clients.store.maids');
    Route::get('/clients/maids/edit/{id}','ClientsController@editmaids')-> name('clients.edit.maids');
    Route::post('/clients/maids/update/{id}','ClientsController@updatemaids')-> name('clients.update.maids');
    Route::post('/addNewValueDEFmaids', 'ClientsController@addNewValueDEFmaids');

    Route::post('/checkcontract', 'ClientsController@checkcontract');
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
    Route::get('/autocomplete_clients', 'ClientsController@autocomplete_clients');
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
    Route::get('/cars/create/{id}','CarsController@create')-> name('cars.create');
    Route::post('/cars/store','CarsController@store')-> name('cars.store');
    Route::post('/caruploadimg', 'CarsController@caruploadimg')-> name('carsimg.attach');
    Route::post('/car_image_delete_file/{id}', 'CarsController@image_delete_file');
    Route::get('/clients/cars/{id}','CarsController@showcars')-> name('clients.showcars');
    Route::get('/clientscarsaction', 'CarsController@actionclientscars');
    Route::get('/carsaction', 'CarsController@action');
    Route::get('/cars/edit/{id}','CarsController@edit')-> name('cars.edit');
    Route::post('/deletecars', 'CarsController@deletecars');
    Route::post('/cars/update/{id}','CarsController@update')-> name('cars.update');
    Route::get('/cars/attach/{id}','CarsController@attachimages')-> name('cars.images');
    Route::get('/clients/attach/{id}','CarsController@attachimages')-> name('clients.attachment');

//    Route::get('/cars/attach/{id}','CarsController@attachimages')-> name('cars.images');

    Route::post('/upload-images-files', 'CarsController@storeIMAGES');
    Route::post('/upload-docs-files', 'CarsController@storeDOCS');
    Route::get('/download-client-files/{id}', 'CarsController@downloadFiles');
    Route::post('/deleteFile', 'CarsController@deleteFile');
    Route::post('/getcarnumbervalide', 'CarsController@getcarnumbervalide');

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
    Route::get('/print-payment-client/{id}','ContractsController@printpayments')-> name('print-payment-client');
    Route::get('/print-clients-statements/{id}/{pdates}', 'ContractsController@getclientsprintout');
    Route::get('/print-clients-payments/{id}/{pdates}', 'ContractsController@getclientspaymentsprintout');
    Route::get('/print-clients-statements-options/{id}/{sql}/{pdates}', 'ContractsController@getclientsprintoutoptions');

    Route::get('/bprint-clients-statements/{id}/{bid}/{type}/{pdates}', 'ContractsController@bgetclientsprintout');
    Route::get('/bprint-clients-payments/{id}/{bid}/{type}/{pdates}', 'ContractsController@bgetclientspaymentsprintout');
    Route::get('/bprint-clients-statements-options/{id}/{sql}/{bid}/{type}/{pdates}', 'ContractsController@bgetclientsprintoutoptions');

    Route::get('/print-bill-client/{id}','ContractsController@printbills')-> name('print-bill-client');
    Route::get('/print-receipt/{id}','ContractsController@printreceipt')-> name('print-receipt');
    Route::get('/print-contract-client/{id}','ContractsController@printcontract')-> name('print-contract-client');
//    Route::get('/contract-client','ContractsController@showall')-> name('contracts-client');
    Route::get('/contracts-list','ContractsController@showall')-> name('contracts-list');
    Route::get('/contract-details/{id}','ContractsController@contractdet')-> name('contract-details');
    Route::get('/contracts-summary','ContractsController@indexcontractsummary')-> name('contracts-summary');
    Route::get('/contractssummary','ContractsController@contractsummary');
    Route::get('/getsummary_usd', 'ContractsController@getsummary_usd');
    Route::get('/getsummary_lbp', 'ContractsController@getsummary_lbp');
    Route::get('/contract-ins-details/create/{id}','ContractsController@create')-> name('contract-ins-details.create');
    Route::post('/contract-ins-details/store','ContractsController@store')-> name('contract-ins-details.store');
    Route::post('/getinsrate', 'ContractsController@getinsrate');
    Route::post('/getinsurance', 'ContractsController@getinsurance');
    Route::get('/getinsname/{id}', 'ContractsController@getinsname');
    Route::post('/getofficeinfo', 'ContractsController@getofficeinfo');
    Route::post('/getbrokerinfo', 'ContractsController@getbrokerinfo');
    Route::get('/getpaymentslist', 'ContractsController@getpaymentslist');
    Route::get('/getcontractlistpayment_usd', 'ContractsController@getcontractlistpayment_usd');
    Route::get('/getcontractlistpayment_lbp', 'ContractsController@getcontractlistpayment_lbp');
    Route::get('/getpayments_usd', 'ContractsController@getpayments_usd');
    Route::get('/getpayments_lbp', 'ContractsController@getpayments_lbp');
    Route::get('/getcontractinslist', 'ContractsController@getcontractinslist');
    Route::post('/billing-status','ContractsController@changeBillingStatus');
    Route::post('/insurance-status','ContractsController@changeInsStatus');
//    Route::post('/getprintpaymentslist', 'ContractsController@getprintpaymentslist');
    Route::post('/editpayment', 'ContractsController@editpayment');
    Route::post('/storepayment', 'ContractsController@storepayment');
    Route::post('/deletepayment', 'ContractsController@deletepayment');
    Route::post('/checkcontpayments', 'ContractsController@checkcontpayments');
    Route::get('/getlidetails', 'ContractsController@getlidetails');
    Route::post('/addNewValuepayments', 'ContractsController@addNewValuepayments');
    Route::post('/addNewValueDEFCONT', 'ContractsController@addNewValueDEFCONT');


    Route::get('/contract-details/edit/{id}','ContractsController@edit')-> name('contract-details.edit');
    Route::post('/contract-details/update/{id}','ContractsController@update')-> name('contract-details.update');
    Route::post('/contract-details/delete/{id}', 'ContractsController@deletedet');
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

    #### Partners Payments Routes
    Route::get('/partners-payments','PaymentsController@indexpayments')-> name('partners-payments');
    Route::post('/getpartnersname', 'PaymentsController@getpartnersname');
    Route::get('/getpartnerslist', 'PaymentsController@getpartnerslist');
    Route::get('/print-partners-statements/{id}/{pid}/{pdates}', 'PaymentsController@getpartnersprintout');
    Route::get('/print-partners-payments/{id}/{pid}/{pdates}', 'PaymentsController@getpartnerspaymentsprintout');
    Route::get('/print-partners-statements-options/{id}/{pid}/{sql}/{pdates}', 'PaymentsController@getpartnersprintoutoptions');

    Route::get('/getpartnerslist_usd', 'PaymentsController@getpartnerslist_usd');
    Route::get('/getpartnerslist_lbp', 'PaymentsController@getpartnerslist_lbp');
    Route::post('/partners-billing-status','PaymentsController@changePartnersBillingStatus');
    Route::get('/pgetpaymentslist','PaymentsController@getpaymentslist');
    Route::get('/getpaymentslist_usd', 'PaymentsController@getpaymentslist_usd');
    Route::get('/getpaymentslist_lbp', 'PaymentsController@getpaymentslist_lbp');
    Route::post('/peditpayment', 'PaymentsController@editpayment');
    Route::post('/pstorepayment', 'PaymentsController@storepayment');
    Route::post('/pdeletepayment', 'PaymentsController@deletepayment');
    Route::get('/gettransactioncashierlist', 'PaymentsController@gettransactioncashierlist');
    Route::get('/getcashier_usd', 'PaymentsController@getcashier_usd');
    Route::get('/getcashier_lbp', 'PaymentsController@getcashier_lbp');
    Route::get('/transactionscahier-list', 'PaymentsController@transactionscahier')->name('transactionscahier-list');

    ###### Accidents
    Route::get('/accident-list','AccidentsController@indexaccidents')-> name('accidents-list');
    Route::get('/accident/create','AccidentsController@create')-> name('accidents.create');
    Route::post('/accident/store','AccidentsController@store')-> name('accidents.store');
    Route::get('/accident/edit/{id}','AccidentsController@edit')-> name('accidents.edit');
    Route::post('/accident/update/{id}','AccidentsController@update')-> name('accidents.update');
    Route::post('/deleteaccident','AccidentsController@deleteaccident');
    Route::get('/accident/show/{id}','AccidentsController@show')-> name('accidents.show');
    Route::post('/addNewValueDEFacc', 'AccidentsController@addNewValueDEFacc');
    Route::post('/getaperson', 'AccidentsController@getaperson');
    Route::post('/getcarvalide', 'AccidentsController@getcarvalide');
    Route::get('/getaccidents', 'AccidentsController@getaccidents');
    Route::post('/getinsurancecode', 'AccidentsController@getinsurancecode');
    Route::get('/getinsnamecode/{id}', 'AccidentsController@getinsnamecode');
    Route::post('/billing-accident-status', 'AccidentsController@changeAccidentBillingStatus');
    Route::post('/accident-status', 'AccidentsController@changeAccStatus');

    ###### Modal Accidents Aperson
    Route::post('/addaperson', 'AccidentsController@addaperson');
    Route::post('/editaperson', 'AccidentsController@editaperson');
    Route::post('/deleteaperson', 'AccidentsController@deleteaperson');
    Route::get('/getapesonacclist', 'AccidentsController@getapesonacclist');
    Route::post('/aperson-status', 'AccidentsController@changeApersonStatus');

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
    Route::get('/getexpenses_usd', 'ExpensesController@getexpenses_usd');
    Route::get('/getexpenses_lbp', 'ExpensesController@getexpenses_lbp');

    ###### Booking
    Route::get('/bookings-list', 'BookingController@index')->name('bookings-list');
    Route::get('/getbookinglist', 'BookingController@getbookinglist');
    Route::post('/editbooking', 'BookingController@editbooking');
    Route::post('/storebooking', 'BookingController@storebooking');
    Route::post('/deletebooking', 'BookingController@deletebooking');
    Route::post('/booking-status','BookingController@changeBookingStatus');

    ###### Booking
    Route::get('/bookings-list', 'BookingController@index')->name('bookings-list');
    Route::get('/getbookinglist', 'BookingController@getbookinglist');
    Route::post('/editbooking', 'BookingController@editbooking');
    Route::post('/storebooking', 'BookingController@storebooking');
    Route::post('/deletebooking', 'BookingController@deletebooking');
    Route::post('/booking-status','BookingController@changeBookingStatus');

    ###### Reporting Section Part
    Route::get('/upcomingcars-list', 'ReportsController@upcomingcars')->name('upcomingcars-list');
    Route::get('/getupcomingcarslist', 'ReportsController@getupcomingcarslist');

    Route::get('/availablecars-list', 'ReportsController@availablecars')->name('availablecars-list');
    Route::get('/getavailablecarslist', 'ReportsController@getavailablecarslist');

    Route::get('/transactionscars-list', 'ReportsController@trasactionscars')->name('transactionscars-list');
    Route::get('/gettransactionscarslist', 'ReportsController@gettransactionscarslist');


    ### Reminders Section
    Route::get('/reminders','RemindersController@index')-> name('reminders');
    Route::get('/reminders-results','RemindersController@remindersresults');
    Route::get('/reminders-results-all','RemindersController@allremindersresults');

    Route::get('/print-reminders-statements/{pdates}', 'RemindersController@getremindersprintout');
    Route::get('/bprint-reminders-statements/{bid}/{type}/{pdates}', 'RemindersController@bgetremindersprintout');


//    Route::get('/gettransactioncashierlist', 'ReportsController@gettransactioncashierlist');
});


