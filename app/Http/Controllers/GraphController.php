<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Hospital;
use App\Staff;
use App\Patient;
use App\Donation;
use App\Chart;

class GraphController extends Controller
{
    //
    public function donationGraph($well_wisher)
	{	

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
	

	}

	public function percentageChange()
	{	


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

	}
}
