<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hospital;
use App\Staff;
use App\Patient;
use App\Donation;
use App\Chart;

class DonationController extends Controller
{
    //

    public function donationList()
	{
	    $donations = Donation::orderBy('id','desc')->paginate(6);

    	return view('donation', ['donations' => $donations]);
	}

	public function registerDonationPage()
	{
	    return view('don_reg_page');
	}

	public function registerDonation(Request $request)
	{
	    
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

	}


	public function editDonationPage($id)
	{
	    
	   	$donation = Donation::find($id);

	 	return view('edit_donation', ['donation' => $donation]);

	}


	public function editDonation(Request $request, $id)
	{
	    
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
		
	}

	public function deleteDonationPage($id)
	{
	    
	   	$donation = Donation::findOrFail($id);

    	return view('/delete_don',['donation' => $donation]);


	}

	public function deleteDonation($id)
	{
	    
	   	Donation::findOrFail($id)->delete();

    	return redirect('/donation')
    		->with('success','Donation record deleted successfully!');

	}

	public function searchDonation(Request $request)
	{
	    
	    $q = $request->q;

	    $donations = Donation::where('well_wisher','LIKE','%'.$q.'%')->paginate(6);
	    
	    return view('donation', ['donations' => $donations,'q' => $q]);
	   
	}
}
