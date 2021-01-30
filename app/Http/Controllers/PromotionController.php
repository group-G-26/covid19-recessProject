<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Hospital;
use App\Staff;
use App\Patient;
use App\Donation;
use App\Chart;

class PromotionController extends Controller
{
    //

    public function promote(Request $request)
	{
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
	}
}
