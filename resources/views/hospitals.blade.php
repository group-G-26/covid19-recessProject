@extends('layouts.admin')

@section('content')

<center><h2 class="pageTitle"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694L1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z"/>
  <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z"/>
</svg> Hospitals</h2></center>

<div class="album py-0 bg-light">


 <div class="container">

 	

 	<div class="row">
 		<div class="col-md-12">
 			<a href="/hospitals" type="button" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
            </svg> <span class="respond">Show all</span></a>

 			<div style="float: right">
			<form class="" action="/search_hospitals" method="GET">
				<div style="display: flex;">
					<input width="50px" name="q" class="form-control search-field" type="text" placeholder="Quick Search" aria-label="Search" value="{{ $q ?? '' }}" >
					<button type="submit" class="btn btn-primary search-btn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                      <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg></button>
				</div>
				
		    </form>
	 	   </div>
 		</div>
 		
 	</div>
 	<br>

    <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="table-responsive">
            <table class="table table-bordered table-sm table-hover">
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>No. of patients</tb>
                    <th>No. of Staff</tb>	
                </tr>
             @if(count($hospitals)  > 0)
                @foreach($hospitals as $hospital)
                <tr>
                    <td>{{ $hospital->id }}</td>
                    <td>{{ substr($hospital->name,0,30) }}</td>
                    <td>{{ $hospital->category }}</td>
                    <td>
                    	
                    	<!-- calculating number of patients -->

                    	<?php

                    		$numPatients = 0;

	                    	foreach($staffs as $staff){

	                    		foreach($patients as $patient){

	                                if($staff->id == $patient->staff_id && $hospital->id == $staff->hos_id){
	                                    $numPatients = $numPatients + 1;
	                                }
	                            }


	                    	}
                            
                            echo $numPatients;

                    	?>

                    	
                    </td>
                    <td>

                    	<!-- calculating number of staff -->

                    	<?php
                    		$numStaff = 0; 
                   			foreach($staffs as $staff){
                   				if($staff->hos_id == $hospital->id){
                   					$numStaff = $numStaff + 1;
                   				}
                   			}
                   			echo $numStaff;
                   		?>


                 	</td>
                </tr>
                @endforeach
                <tr>
                	<th colspan="5" class="page">
                		Showing page {{ $hospitals->currentPage() }} of {{ $hospitals->lastPage() }}
                	</th>
                </tr>
             @endif

             @if(count($hospitals) == 0 )
             	<tr>
	         	  <td colspan="5" class="noRecords">
	            	 No records inserted yet!
	              </td>
             	</tr>
             @endif

            </table>
           </div>

            <div style="float: right">
            	{{ $hospitals->links() }}
            </div>
           
          </div>
    </div>
</div>

@endsection