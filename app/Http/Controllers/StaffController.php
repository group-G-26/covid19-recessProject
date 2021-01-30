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

	}


	public function editStaffPage($id)
	{
	    
	   	$staff = Staff::find($id);

		$hospitals = Hospital::orderBy('id','desc')->get();

		return view('edit_staff', ['staff' => $staff,'hospitals' => $hospitals]);

	}


	public function editStaff(Request $request, $id)
	{
	    

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
