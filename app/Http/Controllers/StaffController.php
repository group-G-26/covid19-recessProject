<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hospital;
use App\Staff;
use App\Patient;
use App\Donation;

class StaffController extends Controller
{
    //

    public function staffList()
	{
	    $staff = Staff::orderBy('id','desc')->paginate(6);

		$hospitals = Hospital::orderBy('id')->get();

		$donations = Donation::orderBy('id')->get();

		$patients = Patient::orderBy('id','desc')->get();

	    return view('staff', ['staffs' => $staff, 'hospitals' => $hospitals, 'patients' => $patients,'donations' => $donations]);
	}

	public function registerStaffPage()
	{
	    
	    $hospitals = Hospital::orderBy('id')->get();

        return view('staff_reg_page', ['hospitals' => $hospitals]);

	}

	public function registerStaff(Request $request)
	{
	    
	    $validator = $request->validate([

	    	'staff_firstname' => 'required|max:100',
		    'staff_lastname' => 'required|max:100',
		    'gender' => 'required|max:10',
		    'position' => 'required|max:50',
	    ]);

	    // Generating a hospital for the staff automatically

		    // calculating number of staff in particular hospital

	    	$hospitals = Hospital::orderBy('id')->get();
	        $staffs = Staff::orderBy('id')->get();

	        $hospitals_found = array();

		    foreach ($hospitals as $hospital) {

				$numStaff = 0;

				foreach($staffs as $staff){
					if($staff->hos_id == $hospital->id && $staff->position == 'Health Officer'){
						$numStaff = $numStaff + 1;
					}
				}

				if($numStaff <= 15 && $hospital->category == 'General Hospital'){
					$hospitals_found[] = $hospital->id;
				}

           	}

            // Getting the ID of the hospital

            $hos_id = $hospitals_found[0];
  	

		$staff = new Staff;
	    $staff->staff_firstname = $request->staff_firstname;
	    $staff->staff_lastname = $request->staff_lastname;
	    $staff->gender = $request->gender;
	    $staff->position = $request->position;
	    $staff->hos_id = $hos_id;
	    $staff->save();

	    return redirect('/staff')
	    	->with('success',  $staff->staff_firstname.' added successfully!');

	}


	public function editStaffPage($id)
	{
	    
	   	$staff = Staff::find($id);

		$hospitals = Hospital::orderBy('id','desc')->get();

		return view('edit_staff', ['staff' => $staff,'hospitals' => $hospitals]);

	}


	public function editStaff(Request $request, $id)
	{
	    

	     $validator = $request->validate([

	    	'staff_firstname' => 'required|max:100',
		    'staff_lastname' => 'required|max:100',
		    'gender' => 'required|max:10',
		    'position' => 'required|max:50',
		    'hos_id' => 'required|max:30',
	    ]);

		$staff = Staff::find($id);

	    $staff->staff_firstname = $request->staff_firstname;
	    $staff->staff_lastname = $request->staff_lastname;
	    $staff->gender = $request->gender;
	    $staff->position = $request->position;
	    $staff->hos_id = $request->hos_id;
	    $staff->update();

	    return redirect('staff')
	            ->with('success', 'Staff details updated successfully');
	   

	}

	public function deleteStaffPage($id)
	{
	    
	   	$staff = Staff::find($id);

    	return view('/delete_staff',['staff' => $staff]);

	}

	public function deleteStaff($id)
	{
	    
	   	$staff = Staff::find($id)->delete();

    	return redirect('/staff')
    	->with('success','Staff record deleted successfully!');

	}

	public function searchStaff(Request $request)
	{
	    
	     $q = $request->q;

	     $staff = Staff::where('staff_firstname','LIKE','%'.$q.'%')
	    				->orWhere('staff_lastname','LIKE','%'.$q.'%')
	    				->orWhere('position', 'LIKE','%'.$q.'%')
	    				->paginate(6);

	     $hospitals = Hospital::orderBy('id')->get();

	     $donations = Donation::orderBy('id','desc')->get();

		 $patients = Patient::orderBy('id','desc')->get();
	    
	    
	     return view('staff', ['hospitals' => $hospitals,'donations' => $donations, 'staffs' => $staff, 'patients' => $patients, 'q' => $q]);
	   

	}

}
