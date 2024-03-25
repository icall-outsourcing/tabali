<?php
ini_set('xdebug.max_nesting_level', 110);

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

App::singleton('lang',function(){
	return App\http\controller\Setting\Setting::lang();
});

Route::get('lang/{lang}', function ($lang){
	if($lang == 'ar')
	{
		session()->put('lang','ar');
	}else{
		session()->put('lang','en');
	}
	return back();
});
//View::share('lang','ar');
//return session()->get('lang');

//dd(session()->get('lang'));
/*
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});
*/


Route::get('/', function () {return redirect('home');});
Route::group(['middleware' => ['web']], function () {
    //
});



    Route::auth();
	Route::any('/home'	, array('as'	=>'home','uses'	=>'HomeController@index'));
	Route::get('/authrole', 'HomeController@authrole');

	//Ajax for all Users
	    Route::post('resetmypassword' , array('as'=>'postpassword'  ,'uses'=>'Setting\UserController@postpassword'));
		Route::any('Search'			 	, array('as'	=>'Search','uses'	=>'AjaxController@Search'));
     	Route::get('Ajaxrelationlist'	, array('as'=>'Ajaxrelationlist','uses'=>'AjaxController@Ajaxrelationlist'));
		Route::get('Ajaxdropdown'    	, array('as'=>'Ajaxdropdown','uses'=>'AjaxController@Ajaxdropdown'));
		Route::get('Ajaxrow'   		 	, array('as'=>'Ajaxrow','uses'=>'AjaxController@Ajaxrow'));
		Route::get('find' 				,'Order\OrderController@find');
  		Route::get('Ajaxtable'			, array('as'=>'Ajaxtable','uses'=>'AjaxController@Ajaxtable'));
  		Route::get('/Order/autoPrint/'	, array('as'=>'Order.print','uses'	=>'Order\OrderController@autoPrint'));
        Route::get('/Complaint'	, array('as'=>'Complaint.index','uses'	=>'ComplaintController@index'));
        Route::get('/Complaint/{id}/edit'	, array('as'=>'Complaint.edit','uses'	=>'ComplaintController@edit'));
  		        
	//Agent Access
        Route::group(['middleware' => 'role:admin||agent'], function () {
			Route::any('/Account/link'		, array('as'=>'Account.link','uses'	=>'Account\AccountController@linkaccount'));
			Route::any('/Contact/link'		, array('as'=>'Contact.link','uses'	=>'Account\ContactController@linkcontact'));
            Route::any('/Address/find/{id}'  	, array('as'=>'Address.find','uses'	=>'Account\AddressController@find'));
			Route::any('/Complaint/sendmail/{id}'	, array('as'=>'Complaint.sendmail','uses'=>'ComplaintController@sendmail'));


			Route::any('/Complaint/create'	, array('as'=>'Complaint.create','uses'	=>'ComplaintController@create'));
			Route::post('/Complaint/store'	, array('as'=>'Complaint.store','uses'	=>'ComplaintController@store'));
			Route::any('/Inquiry/create'	, array('as'=>'Inquiry.create','uses'	=>'InquiryController@create'));
			Route::post('/Inquiry/store'	, array('as'=>'Inquiry.store','uses'	=>'InquiryController@store'));
			Route::resource('Account'	    ,'Account\AccountController');
			Route::resource('Contact'	    ,'Account\ContactController');
			Route::resource('Address'	    ,'Account\AddressController');
        });
        Route::group(['middleware' => 'role:admin||branch||supervisor'], function () {
        	Route::get('/Order/status/{id}'	, array('as'=>'Order.status','uses'	=>'Order\OrderController@statusget'));
        	Route::post('/Order/status/{id}', array('as'=>'Order.statuspost','uses'	=>'Order\OrderController@statuspost'));
			Route::get('/Order/driver/{id}'	, array('as'=>'Order.driver','uses'	=>'Order\OrderController@driverget'));
        	Route::post('/Order/driver/{id}', array('as'=>'Order.driverpost','uses'	=>'Order\OrderController@driverpost'));
			Route::resource('Product'		,'Setting\ProductController');
			Route::resource('Driver'	        ,'Setting\DriverController');
			Route::put('/Complaint/{id}'	, array('as'=>'Complaint.update','uses'	=>'ComplaintController@update'));
			Route::post('/Complaint/{id}/destroy'	, array('as'=>'Complaint.destroy','uses'	=>'ComplaintController@destroy'));
			Route::resource('Report'	,'ReportController');
        });

        Route::group(['middleware' => 'role:admin||supervisor'], function () {
            /*			Route::resource('Driver'	,'Setting\DriverController');*/
			Route::resource('Branch'	,'Setting\BranchController');
			Route::resource('User'		,'Setting\UserController');
			Route::get('/Inquiry'	, array('as'=>'Inquiry.index','uses'	=>'InquiryController@index'));
			Route::get('/Inquiry/{id}'	, array('as'=>'Inquiry.show','uses'	=>'InquiryController@show'));
			Route::get('/Inquiry/{id}/edit'	, array('as'=>'Inquiry.edit','uses'	=>'InquiryController@edit'));
			Route::put('/Inquiry/{id}'	, array('as'=>'Inquiry.update','uses'	=>'InquiryController@update'));
			Route::post('/Inquiry/{id}/destroy'	, array('as'=>'Inquiry.destroy','uses'	=>'InquiryController@destroy'));
        });
        Route::get('/Complaint/{id}'	        , array('as'=>'Complaint.show','uses'	=>'ComplaintController@show'));
        Route::post('/Order/printerUpdate/{id}' , array('as'=>'Order.printerUpdate','uses'	=>'Order\OrderController@printerUpdate'));
        Route::post('/Order/transfer/{id}'      , array('as'=>'Order.transfer','uses'	=>'Order\OrderController@transfer'));
        Route::get('/Order/extraItems/'         , array('as'=>'Order.extraItems','uses'	=>'Order\OrderController@extraItems'));
        
        Route::get('/Order/canceled'	        , array('as'=>'Order.canceled','uses'	=>'Order\OrderController@canceled'));
        Route::get('/Order/closed'	            , array('as'=>'Order.closed','uses'	=>'Order\OrderController@closed'));
        
        
        Route::resource('/Order/'		,'Order\OrderController');
        
        Route::resource('Order'		,'Order\OrderController');





	
	


	
