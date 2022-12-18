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

// Route::get('/', function () {
//     return view('welcome');
// });




/* ------------------ Dashboard -----------------------------*/

// Route::get('/', function () {
//     return view('admin.dashboard');
// });


Route::get('/', 'App\Http\Controllers\DashboardController@totalsales')->middleware('auth');



// Route::get('/customerslist', function () {
//     return view('admin.customerslist');
// });
// Route::get('/admin/customer-details', function () {
//     return view('admin.customer_details');
// });

/* ------------------ Invoice-----------------------------*/

// Route::get('/admin/customer-invoice/create', function () {
//     return view('admin.customer_invoice_add');
// });
Route::get('/admin/customer-invoice/edit', function () {
    return view('admin.customer_invoice_edit');
});


/* ------------------ Invoice-----------------------------*/

// Route::get('/admin/installment-payment/create', function () {
//     return view('admin.payments_installment_add');
// });
Route::get('/admin/installment-payment/edit', function () {
    return view('admin.payments_installment_edit');
});

// Route::get('/admin/customer-payment-add', function () {
//     return view('admin.customers_payment_add');
// });



/* ------------------ Customer Contact -----------------------------*/

Route::get('/contact', function () {
    return view('admin.contact');
});
// Route::get('/admin/sp-invoice', function () {
//     return view('admin.customer_sp_invoice');
// });



/* ------------------ Users -----------------------------*/

// Route::get('/admin/users', function () {
//     return view('admin.users');
// });
// Route::get('/admin/user/create', function () {
//     return view('admin.user_add');
// });
// Route::get('/admin/user/edit', function () {
//     return view('admin.user_edit');
// });
Route::get('/profile', function () {
    return view('admin.profile');
});

/* ------------------ Departments -----------------------------*/

// Route::get('/admin/department', function () {
//     return view('admin.department');
// });
// Route::get('/admin/department/create', function () {
//     return view('admin.department_add');
// });
// Route::get('/admin/department/edit', function () {
//     return view('admin.department_edit');
// });
// Route::get('/admin/departmentlist', function () {
//     return view('admin.departmentlist');
// });
// Route::get('/admin/departmentlisttable', function () {
//     return view('admin.departmentlisttable');
// });

/* ------------------ Institution -----------------------------*/

// Route::get('/admin/institution', function () {
//     return view('admin.institution');
// });
// Route::get('/admin/institution/create', function () {
//     return view('admin.institution_add');
// });
Route::get('/admin/institution/edit', function () {
    return view('admin.institution_edit');
});
Route::get('/admin/institutionlist', function () {
    return view('admin.institutionlist');
});

Route::get('/admin/customer-list', function () {
    return view('admin.customerslist_r_by_institutions');
});

/* ------------------ Reports -----------------------------*/

// Route::get('/admin/letter-report', function () {
//     return view('admin.r_institution_letter_customerslist');
// });
// Route::get('/admin/letter-report-institutions', function () {
//     return view('admin.r_institutions_letter');
// });
Route::get('/admin/cashbook-report', function () {
    return view('admin.report_cashbook');
});


// Route::get('/admin/daily_payments_report', function () {
//     return view('admin.report_daily_payments');
// });



// Route::get('/admin/customers-report', function () {
//     return view('admin.report_customers_monthly');
// });
// Route::get('/admin/institution-report', function () {
//     return view('admin.report_institutions_monthly');
// });
Route::get('/admin/allcustomers-report', function () {
    return view('admin.report_allcustomers');
});

Route::get('/admin/allcustomers_u', function () {
    return view('admin.allcustomers_u');
});


Route::get('/admin/logbook', function () {
    return view('admin.logbook');
});







Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

// middleware groups User

Route::group(['middleware' => 'allusers'] , function(){
    
    Route::get('/customerslist' , 'App\Http\Controllers\CustomerController@indexall')->middleware('auth');
    Route::get('/admin/customer-details/{id}', 'App\Http\Controllers\CustomerController@customer_details')->middleware('auth'); 
    Route::post('/profile/update/{id}','App\Http\Controllers\UsersController@profileupdate')->middleware('auth');
    Route::post('/profile/passowrd/update/{id}','App\Http\Controllers\UsersController@passwordupdate')->middleware('auth');
});




Route::group(['middleware' => 'superadmin'] , function(){
    
    // Route::get('/customerslist' , 'App\Http\Controllers\CustomerController@indexall')->middleware('auth');
    // Route::post('/profile/update/{id}','App\Http\Controllers\UsersController@profileupdate')->middleware('auth');
    // Route::post('/profile/passowrd/update/{id}','App\Http\Controllers\UsersController@passwordupdate')->middleware('auth');

        // users Routes
        
    Route::resource('/admin/users','App\Http\Controllers\UsersController')->middleware('auth');
    Route::get('/user/delete/{id}', 'App\Http\Controllers\UsersController@delete')->middleware('auth');


      // Installment Payments Routes

    // Route::resource('/admin/installment-payment', 'App\Http\Controllers\PaymentController')->middleware('auth');
    // Route::get('/findInvoiceName' , 'App\Http\Controllers\PaymentController@findInvoiceName')->middleware('auth');
    // Route::get('/admin/installment-payment/create/{id}','App\Http\Controllers\PaymentController@paymentcreate')->middleware('auth');
    // Route::post('/admin/installment-payment/update/{id}','App\Http\Controllers\PaymentController@installmentupdate')->middleware('auth');
    // Route::get('/installment/delete/{id}', 'App\Http\Controllers\PaymentController@delete')->middleware('auth');

        // institution Routes

    // Route::resource('/admin/institutions','App\Http\Controllers\InstitutionController')->middleware('auth');
    // Route::get('/admin/institutionlist/{id}', 'App\Http\Controllers\InstitutionController@institutionlist')->middleware('auth');
    // Route::get('/institution/delete/{id}', 'App\Http\Controllers\InstitutionController@delete')->middleware('auth');
    // Route::get('/institution/customers/{id}','App\Http\Controllers\InstitutionController@dcustomerlist')->middleware('auth');

        //customer Routes

    // Route::resource('/admin/customers','App\Http\Controllers\CustomerController')->middleware('auth');
    // Route::get('/findHotelName' , 'App\Http\Controllers\CustomerController@findHotelName')->middleware('auth');
    // Route::get('/admin/customer-details/{id}', 'App\Http\Controllers\CustomerController@customer_details')->middleware('auth'); 
    // Route::get('GetSubCatAgainstMainCatEdit/{id}', 'App\Http\Controllers\CustomerController@GetSubCatAgainstMainCatEdit')->middleware('auth');
    // Route::get('/customer/delete/{id}', 'App\Http\Controllers\CustomerController@delete')->middleware('auth');
    // Route::post('/customer/paymentsettle/{id}','App\Http\Controllers\CustomerController@paymentsettle')->middleware('auth');
    
     // invoice Routes

    //  Route::resource('/admin/Invoice','App\Http\Controllers\InvoiceController')->middleware('auth');
    //  Route::get('/invoice/delete/{id}', 'App\Http\Controllers\InvoiceController@delete')->middleware('auth');
    //  Route::get('/admin/customer-invoice/create/{id}','App\Http\Controllers\InvoiceController@invoicecreate')->middleware('auth');
    //  Route::get('/admin/customer-invoice/edit/{id}','App\Http\Controllers\InvoiceController@invoiceedit')->middleware('auth');
    //  Route::post('/admin/customer-invoice/update/{id}','App\Http\Controllers\InvoiceController@invoiceUpdate')->middleware('auth');


         // department Routes

    // Route::resource('/admin/departments','App\Http\Controllers\DepartmentController')->middleware('auth');
    // Route::get('/admin/departmentlist','App\Http\Controllers\DepartmentController@departmentlist')->middleware('auth');
    // Route::get('/admin/departmentlisttable','App\Http\Controllers\DepartmentController@departmentlisttable')->middleware('auth');
    // Route::get('/department/delete/{id}', 'App\Http\Controllers\DepartmentController@delete')->middleware('auth');


        //Report Routes

        // Route::get('/admin/institution-report','App\Http\Controllers\ReportsController@InstitutionReport')->middleware('auth');
});







//middleware group SuperAdmin & Admin


    
    // Installment Payments Routes

    // Route::resource('/admin/installment-payment', 'App\Http\Controllers\PaymentController');
    // Route::get('/findInvoiceName' , 'App\Http\Controllers\PaymentController@findInvoiceName');
    // Route::get('/admin/installment-payment/create/{id}','App\Http\Controllers\PaymentController@paymentcreate');
    // Route::post('/admin/installment-payment/update/{id}','App\Http\Controllers\PaymentController@installmentupdate');
    // Route::get('/installment/delete/{id}', 'App\Http\Controllers\PaymentController@delete');  
    
    

    // department Routes

    // Route::resource('/admin/departments','App\Http\Controllers\DepartmentController');
    // Route::get('/admin/departmentlist','App\Http\Controllers\DepartmentController@departmentlist');
    // Route::get('/admin/departmentlisttable','App\Http\Controllers\DepartmentController@departmentlisttable');
    // Route::get('/department/delete/{id}', 'App\Http\Controllers\DepartmentController@delete');


    // invoice Routes

    // Route::resource('/admin/Invoice','App\Http\Controllers\InvoiceController');
    // Route::get('/invoice/delete/{id}', 'App\Http\Controllers\InvoiceController@delete');
    // Route::get('/admin/customer-invoice/create/{id}','App\Http\Controllers\InvoiceController@invoicecreate');
    // Route::get('/admin/customer-invoice/edit/{id}','App\Http\Controllers\InvoiceController@invoiceedit');
    // Route::post('/admin/customer-invoice/update/{id}','App\Http\Controllers\InvoiceController@invoiceUpdate');

    //customer Routes

    // Route::resource('/admin/customers','App\Http\Controllers\CustomerController');
    // Route::get('/findHotelName' , 'App\Http\Controllers\CustomerController@findHotelName');
    // Route::get('/admin/customer-details/{id}', 'App\Http\Controllers\CustomerController@customer_details'); 
    // Route::get('GetSubCatAgainstMainCatEdit/{id}', 'App\Http\Controllers\CustomerController@GetSubCatAgainstMainCatEdit');
    // Route::get('/customer/delete/{id}', 'App\Http\Controllers\CustomerController@delete');


    // institution Routes

    // Route::resource('/admin/institutions','App\Http\Controllers\InstitutionController');
    // Route::get('/admin/institutionlist/{id}', 'App\Http\Controllers\InstitutionController@institutionlist');
    // Route::get('/institution/delete/{id}', 'App\Http\Controllers\InstitutionController@delete');




//middleware group SuperAdmin

    
  // users Routes
    
    // Route::resource('/admin/users','App\Http\Controllers\UsersController')->middleware('auth');
    // Route::get('/user/delete/{id}', 'App\Http\Controllers\UsersController@delete')->middleware('auth');



     // Installment Payments Routes

    //  Route::resource('/admin/installment-payment', 'App\Http\Controllers\PaymentController')->middleware('auth');
    //  Route::get('/findInvoiceName' , 'App\Http\Controllers\PaymentController@findInvoiceName')->middleware('auth');
    //  Route::get('/admin/installment-payment/create/{id}','App\Http\Controllers\PaymentController@paymentcreate')->middleware('auth');
    //  Route::post('/admin/installment-payment/update/{id}','App\Http\Controllers\PaymentController@installmentupdate')->middleware('auth');
    //  Route::get('/installment/delete/{id}', 'App\Http\Controllers\PaymentController@delete')->middleware('auth');


      // institution Routes

    // Route::resource('/admin/institutions','App\Http\Controllers\InstitutionController')->middleware('auth');
    // Route::get('/admin/institutionlist/{id}', 'App\Http\Controllers\InstitutionController@institutionlist')->middleware('auth');
    // Route::get('/institution/delete/{id}', 'App\Http\Controllers\InstitutionController@delete')->middleware('auth');
    // Route::get('/institution/customers/{id}','App\Http\Controllers\InstitutionController@dcustomerlist')->middleware('auth');


      //customer Routes

    // Route::resource('/admin/customers','App\Http\Controllers\CustomerController')->middleware('auth');
    // Route::get('/findHotelName' , 'App\Http\Controllers\CustomerController@findHotelName')->middleware('auth');
    // Route::get('/admin/customer-details/{id}', 'App\Http\Controllers\CustomerController@customer_details')->middleware('auth'); 
    // Route::get('GetSubCatAgainstMainCatEdit/{id}', 'App\Http\Controllers\CustomerController@GetSubCatAgainstMainCatEdit')->middleware('auth');
    // Route::get('/customer/delete/{id}', 'App\Http\Controllers\CustomerController@delete')->middleware('auth');
    // Route::post('/customer/paymentsettle/{id}','App\Http\Controllers\CustomerController@paymentsettle')->middleware('auth');

    


      // invoice Routes

    // Route::resource('/admin/Invoice','App\Http\Controllers\InvoiceController')->middleware('auth');
    // Route::get('/invoice/delete/{id}', 'App\Http\Controllers\InvoiceController@delete')->middleware('auth');
    // Route::get('/admin/customer-invoice/create/{id}','App\Http\Controllers\InvoiceController@invoicecreate')->middleware('auth');
    // Route::get('/admin/customer-invoice/edit/{id}','App\Http\Controllers\InvoiceController@invoiceedit')->middleware('auth');
    // Route::post('/admin/customer-invoice/update/{id}','App\Http\Controllers\InvoiceController@invoiceUpdate')->middleware('auth');


    // department Routes

    // Route::resource('/admin/departments','App\Http\Controllers\DepartmentController')->middleware('auth');
    // Route::get('/admin/departmentlist','App\Http\Controllers\DepartmentController@departmentlist')->middleware('auth');
    // Route::get('/admin/departmentlisttable','App\Http\Controllers\DepartmentController@departmentlisttable')->middleware('auth');
    // Route::get('/department/delete/{id}', 'App\Http\Controllers\DepartmentController@delete')->middleware('auth');
    





    
//     // department Routes


//     Route::resource('/admin/departments','App\Http\Controllers\DepartmentController');
//     Route::get('/admin/departmentlist','App\Http\Controllers\DepartmentController@departmentlist');
//     Route::get('/admin/departmentlisttable','App\Http\Controllers\DepartmentController@departmentlisttable');
//     Route::get('/department/delete/{id}', 'App\Http\Controllers\DepartmentController@delete');




//     // invoice Routes


//     Route::resource('/admin/Invoice','App\Http\Controllers\InvoiceController');
//     Route::get('/invoice/delete/{id}', 'App\Http\Controllers\InvoiceController@delete');
//     Route::get('/admin/customer-invoice/create/{id}','App\Http\Controllers\InvoiceController@invoicecreate');
//     Route::get('/admin/customer-invoice/edit/{id}','App\Http\Controllers\InvoiceController@invoiceedit');
//     Route::post('/admin/customer-invoice/update/{id}','App\Http\Controllers\InvoiceController@invoiceUpdate');




//          //customer Routes

//     Route::resource('/admin/customers','App\Http\Controllers\CustomerController');
//     Route::get('/findHotelName' , 'App\Http\Controllers\CustomerController@findHotelName');
//     Route::get('/admin/customer-details/{id}', 'App\Http\Controllers\CustomerController@customer_details'); 
//     Route::get('GetSubCatAgainstMainCatEdit/{id}', 'App\Http\Controllers\CustomerController@GetSubCatAgainstMainCatEdit');
//     Route::get('/customer/delete/{id}', 'App\Http\Controllers\CustomerController@delete');





//               // institution Routes


//     Route::resource('/admin/institutions','App\Http\Controllers\InstitutionController');
//     Route::get('/admin/institutionlist/{id}', 'App\Http\Controllers\InstitutionController@institutionlist');
//     Route::get('/institution/delete/{id}', 'App\Http\Controllers\InstitutionController@delete');



//          // Installment Payments Routes


        //  Route::resource('/admin/installment-payment', 'App\Http\Controllers\PaymentController');
        //  Route::get('/findInvoiceName' , 'App\Http\Controllers\PaymentController@findInvoiceName');
        //  Route::get('/admin/installment-payment/create/{id}','App\Http\Controllers\PaymentController@paymentcreate');
        //  Route::post('/admin/installment-payment/update/{id}','App\Http\Controllers\PaymentController@installmentupdate');
        //  Route::get('/installment/delete/{id}', 'App\Http\Controllers\PaymentController@delete');

        Route::group(['middleware' => 'auth'] , function(){


            Route::group(['middleware' => 'SuperAdminAdmin'] , function(){
    
                // Route::get('/customerslist' , 'App\Http\Controllers\CustomerController@indexall')->middleware('auth');
                // Route::post('/profile/update/{id}','App\Http\Controllers\UsersController@profileupdate')->middleware('auth');
                // Route::post('/profile/passowrd/update/{id}','App\Http\Controllers\UsersController@passwordupdate')->middleware('auth');
            
                    Route::get('/admin/daily_payments_report' , 'App\Http\Controllers\ReportsController@daily_payments_report')->middleware('auth'); 
                    Route::get('/admin/log-institution-report' , 'App\Http\Controllers\ReportsController@loginstitutionreport')->middleware('auth'); 
                //  Installment Payments Routes
            
                Route::resource('/admin/installment-payment', 'App\Http\Controllers\PaymentController')->middleware('auth');
                Route::get('/findInvoiceName' , 'App\Http\Controllers\PaymentController@findInvoiceName')->middleware('auth');
                Route::get('/admin/installment-payment/create/{id}','App\Http\Controllers\PaymentController@paymentcreate')->middleware('auth');
                Route::post('/admin/installment-payment/update/{id}','App\Http\Controllers\PaymentController@installmentupdate')->middleware('auth');
                Route::get('/installment/delete/{id}', 'App\Http\Controllers\PaymentController@delete')->middleware('auth');
            
            
                // institution Routes
            
                Route::resource('/admin/institutions','App\Http\Controllers\InstitutionController')->middleware('auth');
                Route::get('/admin/institutionlist/{id}', 'App\Http\Controllers\InstitutionController@institutionlist')->middleware('auth');
                Route::get('/institution/delete/{id}', 'App\Http\Controllers\InstitutionController@delete')->middleware('auth');
                Route::get('/institution/customers/{id}','App\Http\Controllers\InstitutionController@dcustomerlist')->middleware('auth');
            
                // custome?rs Routes
            
                Route::resource('/admin/customers','App\Http\Controllers\CustomerController')->middleware('auth');
                
                // Route::get('/admin/customer-details/{id}', 'App\Http\Controllers\CustomerController@customer_details')->middleware('auth'); 
                Route::get('GetSubCatAgainstMainCatEdit/{id}', 'App\Http\Controllers\CustomerController@GetSubCatAgainstMainCatEdit')->middleware('auth');
                Route::get('/customer/delete/{id}', 'App\Http\Controllers\CustomerController@delete')->middleware('auth');
                Route::post('/customer/paymentsettle/{id}','App\Http\Controllers\CustomerController@paymentsettle')->middleware('auth');
            
                ;
            
                //   invoice Routes
            
                Route::resource('/admin/Invoice','App\Http\Controllers\InvoiceController')->middleware('auth');
                Route::get('/invoice/delete/{id}', 'App\Http\Controllers\InvoiceController@delete')->middleware('auth');
                Route::get('/admin/customer-invoice/create/{id}','App\Http\Controllers\InvoiceController@invoicecreate')->middleware('auth');
                Route::get('/admin/customer-invoice/edit/{id}','App\Http\Controllers\InvoiceController@invoiceedit')->middleware('auth');
                Route::post('/admin/customer-invoice/update/{id}','App\Http\Controllers\InvoiceController@invoiceUpdate')->middleware('auth');
                Route::get('/admin/sp-invoice','App\Http\Controllers\InvoiceController@SpInvoice')->middleware('auth');
                
            
                //   department Routes
            
                Route::resource('/admin/departments','App\Http\Controllers\DepartmentController')->middleware('auth');
                Route::get('/admin/departmentlist','App\Http\Controllers\DepartmentController@departmentlist')->middleware('auth');
                Route::get('/admin/departmentlisttable','App\Http\Controllers\DepartmentController@departmentlisttable')->middleware('auth');
                Route::get('/department/delete/{id}', 'App\Http\Controllers\DepartmentController@delete')->middleware('auth');
            
            
            
               // Reports Routes
            
                Route::get('/admin/institution-report','App\Http\Controllers\ReportsController@InstitutionReport')->middleware('auth');
                Route::get('/admin/customers-report/{id}','App\Http\Controllers\ReportsController@CustomersReport')->middleware('auth');
                Route::get('/admin/logbook/{id}','App\Http\Controllers\ReportsController@logbook')->middleware('auth');
                Route::get('/admin/letter-report-institutions','App\Http\Controllers\ReportsController@LetterReportInstitutions')->middleware('auth');
                Route::get('/admin/letter-report/{id}','App\Http\Controllers\ReportsController@LetterReport')->middleware('auth');
                Route::get('/admin/allcustomers-report','App\Http\Controllers\ReportsController@AllCustomersReport')->middleware('auth');
                Route::get('/admin/cashbook-report','App\Http\Controllers\ReportsController@CashBookReport')->middleware('auth');
                Route::post('/admin/cashbook-report','App\Http\Controllers\ReportsController@SearchByDate')->middleware('auth');
                Route::get('/admin/allcustomers_u','App\Http\Controllers\ReportsController@allcustomers_u')->middleware('auth');

                // SMS Routes

                
                Route::resource('/admin/customers_list_sms', 'App\Http\Controllers\SmsController');
                Route::post('/admin/sendmessage','App\Http\Controllers\SmsController@sendMessage');
                Route::post('/admin/singlemessage','App\Http\Controllers\SmsController@sendOneMessage');
            });






        });


         


