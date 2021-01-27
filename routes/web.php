<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\User;
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


// login page

Route::get('/', function () {
    return view('auth/login');
});

// patients page

Route::get('/patients', function () {

	$patients = Patient::orderBy('id','desc')->paginate(5);

	$staff = Staff::orderBy('id','desc')->get();

    return view('patients',['patients' => $patients,'staffs' => $staff]);

})->middleware('auth');

// staff page

Route::get('/staff', function () {

	$staff = Staff::orderBy('id','desc')->paginate(5);

	$hospitals = Hospital::orderBy('id')->get();

	$donations = Donation::orderBy('id')->get();

	$patients = Patient::orderBy('id','desc')->get();

    return view('staff', ['staffs' => $staff, 'hospitals' => $hospitals, 'patients' => $patients,'donations' => $donations]);

})->middleware('auth');


//staff reg page 

Route::get('/staff_reg_page', function () {

	$hospitals = Hospital::orderBy('id')->get();
    return view('staff_reg_page', ['hospitals' => $hospitals]);

})->middleware('auth','admin');

// staff registration 

Route::post('/staff_reg', function (Request $request) {

	$validator = Validator::make($request->all(), [
	    'staff_firstname' => 'required|max:255',
	    'staff_lastname' => 'required|max:255',
	    'gender' => 'required|max:10',
	    'position' => 'required|max:255',
	    'hos_id' => 'required|max:30',
	]);

	if ($validator->fails()) {
	    return redirect('staff_reg_page')
	        ->withInput()
	        ->withErrors($validator);
	}

	$staff = new Staff;
    $staff->staff_firstname = $request->staff_firstname;
    $staff->staff_lastname = $request->staff_lastname;
    $staff->gender = $request->gender;
    $staff->position = $request->position;
    $staff->hos_id = $request->hos_id;
    $staff->save();

    return redirect('/staff')
    	->with('success',  $staff->staff_firstname.' added successfully!');
})->middleware('auth');


// hospitals

Route::get('/hospitals', function () {
	$hospitals = Hospital::orderBy('id', 'asc')->paginate(5);

	$staff = Staff::orderBy('id')->get();

	$patients = Patient::orderBy('id')->get();

    return view('hospitals', ['hospitals' => $hospitals, 'staffs' => $staff, 'patients' => $patients]);

})->middleware('auth');

// donations

Route::get('/donation', function () {

	$donations = Donation::orderBy('id','desc')->paginate(5);

    return view('donation', ['donations' => $donations]);

})->middleware('auth');

//Donation registration page

Route::get('/don_reg_page', function () {

    return view('don_reg_page');

})->middleware('auth','admin');


// register a donation

Route::post('/don_reg', function (Request $request) {

	$validator = Validator::make($request->all(), [
	    'well_wisher' => 'required|max:255',
	    'amount' => 'required|max:255',
	]);

	if ($validator->fails()) {
	    return redirect('don_reg_page')
	        ->withInput()
	        ->withErrors($validator);
	}

	$donation = new Donation;
    $donation->well_wisher = $request->well_wisher;
    $donation->amount = $request->amount;
    $donation->save();

    return redirect('/donation')
    	->with('success', 'Donation added successfully!');

})->middleware('auth');



Auth::routes();

//homepage

Route::get('/home', function () {

	// Graph

	$results = Donation::orderBy('id','asc')->get();
	$totals = array();

	for($x = 1; $x <= 12; $x++ ){

		$total_per_month = 50000000;

		foreach($results as $v){
			if($x < 10){
				if(substr($v->created_at,0,7) == date('Y-0'.$x)){
				 	$total_per_month = $total_per_month + $v->amount;
				}
			}else if($x > 9){
				if(substr($v->created_at,0,7) == date('Y-'.$x)){
				 	$total_per_month = $total_per_month + $v->amount;
				}
			}

		}

		$totals[] = $total_per_month;
	}

    $month = array('Jan', 'Feb', 'Mar', 'Apr', 'May','June','Jul','Aug','Sept','Oct','Nov','Dec');

    // Generate random colours for the groups
    for ($i=0; $i<= 12; $i++) {
                $colours[] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
            }

    // Prepare the data for returning with the view
    $chart = new Chart;
            $chart->labels = (array_values($month));
            $chart->dataset = (array_values($totals));
            $chart->colours = $colours;


        // tables

	$staff = Staff::orderBy('id','desc')->get();

	$patients = Patient::orderBy('id','desc')->get();

	$hospitals = Hospital::orderBy('id','desc')->get();

	$donations = Donation::orderBy('id','desc')->get();

    return view('home', ['staffs' => $staff,'patients' => $patients,'hospitals' => $hospitals,'donations' => $donations, 'chart' => $chart]);

})->middleware('auth');


// Error page

Route::get('/errorPage', function () {

    return view('errorPage');

})->middleware('auth');



// Delete donation confirmation

Route::get('/delete_don/{id}', function ($id) {

    $donation = Donation::findOrFail($id);

    return view('/delete_don',['donation' => $donation]);

})->middleware('auth', 'admin');


// Actual Delete donation

Route::delete('/del_don/{id}', function ($id) {

    Donation::findOrFail($id)->delete();

    return redirect('/donation')
    	->with('success','Donation record deleted successfully!');

})->middleware('auth', 'admin');



// Delete staff  confirmation

Route::get('/delete_staff/{id}', function ($id) {

    $staff = Staff::find($id);

    return view('/delete_staff',['staff' => $staff]);

})->middleware('auth', 'admin');


// Actual Delete staff

Route::delete('/del_staff/{id}', function ($id) {

    $staff = Staff::find($id)->delete();

    return redirect('/staff')
    	->with('success','Staff record deleted successfully!');

})->middleware('auth', 'admin');


// search for hospital

Route::any('/search_hospitals',function(Request $request){
    $q = $request->q;

    $hospitals = Hospital::where('name','LIKE','%'.$q.'%')
    						->orWhere('category', 'LIKE','%'.$q.'%')
    						->paginate(5);

    $staff = Staff::orderBy('id')->get();

	$patients = Patient::orderBy('id')->get();
    
    
    return view('hospitals', ['hospitals' => $hospitals, 'staffs' => $staff, 'patients' => $patients, 'q' => $q]);

})->middleware('auth');

// search for Staff

Route::any('/search_staff',function(Request $request){

    $q = $request->q;

    $staff = Staff::where('staff_firstname','LIKE','%'.$q.'%')
    				->orWhere('staff_lastname','LIKE','%'.$q.'%')
    				->orWhere('position', 'LIKE','%'.$q.'%')
    				->paginate(5);

    $hospitals = Hospital::orderBy('id')->get();

	$patients = Patient::orderBy('id','desc')->get();
    
    
    return view('staff', ['hospitals' => $hospitals, 'staffs' => $staff, 'patients' => $patients, 'q' => $q]);

})->middleware('auth');;

// search for donation

Route::any('/search_donation',function(Request $request){

    $q = $request->q;

    $donations = Donation::where('well_wisher','LIKE','%'.$q.'%')->paginate(5);
    
    return view('donation', ['donations' => $donations,'q' => $q]);

})->middleware('auth');;

// search for patient

Route::any('/search_patients',function(Request $request){

    $q = $request->q;

    $patients = Patient::where('pat_name','LIKE','%'.$q.'%')->paginate(5);

    $staff = Staff::orderBy('id')->get();
    
    return view('patients', ['staffs' => $staff, 'patients' => $patients, 'q' => $q]);

})->middleware('auth');



//logout

Route::get('/logout', 'LogoutController@logout')->name('/');



// Edit Donation Page

Route::get('/edit_donation/{id}', function($id){

	$donation = Donation::find($id);

	 return view('edit_donation', ['donation' => $donation]);

})->middleware('auth', 'admin');

// Update Donation

Route::patch('/update_donation/{id}', function(Request $request, $id){

		

	    $request->validate([
            'well_wisher' => 'required',
            'amount' => 'required|max:255'
        ]);

        $donation = Donation::find($id);

        $donation->well_wisher = $request->well_wisher;
        $donation->amount = $request->amount;

        $donation->update();

        return redirect('donation')
            ->with('success', 'Donation updated successfully');

})->middleware('auth', 'admin');



// Edit Staff Page

Route::get('/edit_staff/{id}', function($id){

	$staff = Staff::find($id);

	$hospitals = Hospital::orderBy('id','desc')->get();

	 return view('edit_staff', ['staff' => $staff,'hospitals' => $hospitals]);

})->middleware('auth', 'admin');

// Update Staff info

	Route::patch('/update_staff/{id}', function(Request $request, $id){

		$validator = Validator::make($request->all(), [
		    'staff_firstname' => 'required|max:255',
		    'staff_lastname' => 'required|max:255',
		    'gender' => 'required|max:10',
		    'position' => 'required|max:255',
		    'hos_id' => 'required|max:30',
		]);

		if ($validator->fails()) {
		    return redirect('/staff_reg')
		        ->withInput()
		        ->withErrors($validator);
		}

		$staff = Staff::find($id);

	    $staff->staff_firstname = $request->staff_firstname;
	    $staff->staff_lastname = $request->staff_lastname;
	    $staff->gender = $request->gender;
	    $staff->position = $request->position;
	    $staff->hos_id = $request->hos_id;
	    $staff->update();

	    return redirect('staff')
	            ->with('success', 'Staff details updated successfully');

	})->middleware('auth', 'admin');


	// This route entirely is used to confirm promotions

	Route::get('/confirm_promotions', function(Request $request){

		$staffs = Staff::orderBy('id','desc')->get();
		$patients = Patient::orderBy('id','desc')->get();

        foreach ($staffs as $staff) {
        
            $numb = 0;

            foreach($patients as $patient){
                if($staff->id == $patient->staff_id){
                    $numb = $numb + 1;
                }

            }

            // checking if the health officer has reached 
            // required number of patients

            if($numb >= 100 && $staff->position == 'Health Officer'){

                // change postion

                $staffPromote = Staff::find($staff->id);

		        $staffPromote->position = 'Senior Health Officer';

		        $staffPromote->update();

            }else if($numb >= 900 && $staff->position == 'Senior Health Officer'){
                // change the positon

                $staffPromote = Staff::find($staff->id);

		        $staffPromote->position = 'Consultant';

		        $staffPromote->update();

            }

        }

	    return redirect('home')
	            ->with('promoted', 'Successfully confirmed');

	})->middleware('auth', 'admin');





	// Graph As Selected By Admin/Dir


	Route::get('/donation_graph/{well_wisher}', function(Request $request, $well_wisher){

		$results = Donation::select('*')->where('well_wisher','=', $well_wisher)->get();

		$totals = array();

		for($x = 1; $x <= 12; $x++ ){

			$total_per_month = 0;
			foreach($results as $v){
				if($x < 10){
					if(substr($v->created_at,0,7) == date('Y-0'.$x)){
					 	$total_per_month = $total_per_month + $v->amount;
					}
				}else if($x > 9){
					if(substr($v->created_at,0,7) == date('Y-'.$x)){
					 	$total_per_month = $total_per_month + $v->amount;
					}
				}

			}

			$totals[] = $total_per_month;
		}

	    $month = array('Jan', 'Feb', 'Mar', 'Apr', 'May','June','Jul','Aug','Sept','Oct','Nov','Dec');

	    // Generate random colours for the groups
	    for ($i=0; $i<= 12; $i++) {
	                $colours[] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
	            }

	    // Prepare the data for returning with the view
	    $chart = new Chart;
	       		$chart->labels = (array_values($month));
	            $chart->dataset = (array_values($totals));
	            $chart->colours = $colours;

	    return view('/donation_graph', ['chart' => $chart, 'well_wisher' => $well_wisher]);

	})->middleware('auth');


	// Percentage change in enrollment figures


	Route::get('/graphical', function(Request $request){

		$results = Patient::orderBy('id')->get();

		$totals = array();

		for($x = 1; $x <= 12; $x++ ){

			$total_per_month = 1;
			foreach($results as $v){
				if($x < 10){
					if(substr($v->date,0,7) == date('Y-0'.$x)){
					 	$total_per_month = $total_per_month + 1;
					}
				}else if($x > 9){
					if(substr($v->date,0,7) == date('Y-'.$x)){
					 	$total_per_month = $total_per_month + 1;
					}
				}

			}

			$totals[] = $total_per_month;
		}

		$percentage = array();

		for($x = 0; $x < count($totals); $x++){
			if($x == 11){
				$value = ($totals[$x] - $totals[$x - 1])/$totals[$x - 1];
				$percentage[] = $value;
			}
			else{
				$value = ($totals[$x + 1] - $totals[$x])/$totals[$x];
				$percentage[] = $value;
			}
		}

	    $month = array('Jan', 'Feb', 'Mar', 'Apr', 'May','June','Jul','Aug','Sept','Oct','Nov','Dec');

	    // Generate random colours for the groups
	    for ($i=0; $i<= 12; $i++) {
	                $colours[] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
	            }

	    // Prepare the data for returning with the view
	    $chart = new Chart;
	       		$chart->labels = (array_values($month));
	            $chart->dataset = (array_values($percentage));
	            $chart->colours = $colours;

	    return view('/graphical', ['chart' => $chart]);

	})->middleware('auth');


?>