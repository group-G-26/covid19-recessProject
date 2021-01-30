<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hospital;
use App\Staff;
use App\Patient;
use App\Donation;
use App\Chart;

class HomeController extends Controller
{
    //

	public function index()
	{
	    
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


	}

}
