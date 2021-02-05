<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Hospital;
use App\Staff;
use App\Patient;
use App\Donation;
use App\Chart;


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


	Auth::routes();

	//homepage

	Route::get('/home', 'HomeController@index')->middleware('auth');

	// login page

	Route::get('/', function () {
	    return view('auth/login');
	});

	//logout

	Route::get('/logout', 'LogoutController@logout');



	// staff page

	Route::get('/staff', 'StaffController@staffList')->middleware('auth');


	//staff reg page 

	Route::get('/staff_reg_page', 'StaffController@registerStaffPage')->middleware('auth','admin');

	// staff registration 

	Route::post('/staff_reg','StaffController@registerStaff')->middleware('auth');



	// donations

	Route::get('/donation', 'DonationController@donationList')->middleware('auth');

	//Donation registration page

	Route::get('/don_reg_page', 'DonationController@registerDonationPage')->middleware('auth','admin');


	// register a donation

	Route::post('/don_reg', 'DonationController@registerDonation')->middleware('auth');


	// Delete donation confirmation

	Route::get('/delete_don/{id}', 'DonationController@deleteDonationPage')->middleware('auth', 'admin');


	// Actual Delete donation

	Route::delete('/del_don/{id}', 'DonationController@deleteDonation')->middleware('auth', 'admin');



	// Delete staff  confirmation

	Route::get('/delete_staff/{id}', 'StaffController@deleteStaffPage')->middleware('auth', 'admin');


	// Actual Delete staff

	Route::delete('/del_staff/{id}', 'StaffController@deleteStaff')->middleware('auth', 'admin');

	// search for Staff

	Route::any('/search_staff', 'StaffController@searchStaff')->middleware('auth');

	// search for donation

	Route::any('/search_donation','DonationController@searchDonation')->middleware('auth');


    // Edit Donation Page

	Route::get('/edit_donation/{id}', 'DonationController@editDonationPage')->middleware('auth', 'admin');

	// Update Donation

	Route::patch('/update_donation/{id}', 'DonationController@editDonation')->middleware('auth', 'admin');



	// Edit Staff Page

	Route::get('/edit_staff/{id}', 'StaffController@editStaffPage')->middleware('auth', 'admin');

	// Update Staff info

	Route::patch('/update_staff/{id}', 'StaffController@editStaff')->middleware('auth', 'admin');


	// This route entirely is used to confirm promotions

	Route::get('/confirm_promotions', 'PromotionController@promote')->middleware('auth', 'admin');


	// Graph As Selected By Admin/Dir


	Route::get('/donation_graph/{well_wisher}', 'GraphController@donationGraph')->middleware('auth');


	// Percentage change in enrollment figures


	Route::get('/graphical', 'GraphController@percentageChange')->middleware('auth');


	// Error page

	Route::get('/errorPage', function () {

	    return view('errorPage');

	})->middleware('auth');


	// patients page

	Route::get('/patients', function () {

		$patients = Patient::orderBy('id','desc')->paginate(6);

		$staff = Staff::orderBy('id','desc')->get();

	    return view('patients',['patients' => $patients,'staffs' => $staff]);

	})->middleware('auth');



	// hospitals

	Route::get('/hospitals', function () {
		$hospitals = Hospital::orderBy('id', 'asc')->paginate(6);

		$staff = Staff::orderBy('id')->get();

		$patients = Patient::orderBy('id')->get();

	    return view('hospitals', ['hospitals' => $hospitals, 'staffs' => $staff, 'patients' => $patients]);

	})->middleware('auth');


	// search for hospital

	Route::any('/search_hospitals',function(Request $request){
	    $q = $request->q;

	    $hospitals = Hospital::where('name','LIKE','%'.$q.'%')
	    						->orWhere('category', 'LIKE','%'.$q.'%')
	    						->paginate(6);

	    $staff = Staff::orderBy('id')->get();

		$patients = Patient::orderBy('id')->get();
	    
	    
	    return view('hospitals', ['hospitals' => $hospitals, 'staffs' => $staff, 'patients' => $patients, 'q' => $q]);

	})->middleware('auth');



	// search for patient

	Route::any('/search_patients',function(Request $request){

	    $q = $request->q;

	    $patients = Patient::where('pat_name','LIKE','%'.$q.'%')->paginate(6);

	    $staff = Staff::orderBy('id')->get();
	    
	    return view('patients', ['staffs' => $staff, 'patients' => $patients, 'q' => $q]);

	})->middleware('auth');	


?>