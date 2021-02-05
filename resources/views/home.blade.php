@extends('layouts.admin')

@section('content')

<div class="album py-0 bg-light">
<div class="container">

  <div class="row">
  <!--   Alerts -->

    <div class="col-md-12">
           

      <?php


            // An alert of salaries

          if(date('j') == 28 || date('j') == 29 || date('j') == 30 || date('j') == 31){


                echo '<div class="alert alert-success">


                     <h4 class="text-center"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
                    <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z"/>
                     </svg>
                     </h4>


                      <p class="text-center">';
                    



                // Donations in current month.

                $amount1 = 50000000;
                foreach($donations as $donation){
                    if(substr($donation->created_at,0,7) == date('Y-m')){
                        $amount1 = $donation->amount + $amount1;
                    }
                }
                
                if($amount1 <= 100000000){
                    echo 'The treasury recieved less than 100 million this month hence no salary has been issued as per policy!';
                }else{
                    echo 'Salary for this month has been issued <a href="/staff" type="button" class="btn btn-success">see details &rarr;</a>';
                }

                echo '</p>
                </div>';
            }

      ?>
    
    


           <!-- An alert that confirms a promotion -->

        @if(session('promoted'))
                <div class="alert alert-success">
                  <p class="text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-emoji-smile-fill" viewBox="0 0 16 16">
                      <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zM4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683zM10 8c-.552 0-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5S10.552 8 10 8z"/>
                    </svg> {{ session('promoted') }}
                  </p>
               </div>
              
        @endif
    </div>          
  </div>
  

    <!-- Dashboard -->


<div class="col-md-12">
   
      <div class="card-group">
        <div class="card">
          <div class="card-body">
            <h2 class="card-title">

              <?php
              
              //  Getting number of health officers

                $officers = 0;

                foreach($staffs as $staff){
                    if($staff->position == 'Health Officer'){
                        $officers = $officers + 1;
                    }
                }

                echo number_format($officers);

              ?>

            </h2>

              <p class="card-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
              <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
            </svg> Health Officers</p>

            <p class="card-text"><small class="text-muted"><a type="button" class="btn btn-sm btn-outline-secondary" href="/staff">View Details &rarr;</a> </small></p>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <h2 class="card-title">{{ number_format(count($hospitals)) }}</h2>

            <p class="card-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694L1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z"/>
              <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z"/>
            </svg> Hospitals</p>

            <p class="card-text"><small class="text-muted"><a type="button" class="btn btn-sm btn-outline-secondary" href="/hospitals">View Details &rarr;</a></small></p>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <h2 class="card-title">

                   <?php

                        // Determining current day donations

                        $numb = 0;
                        foreach($donations as $donation){

                            if(substr($donation->created_at,8,2) == date('j')){  
                                $numb = $numb + 1;
                            }

                           
                        }

                        echo number_format($numb);
                        
                  ?>
                        
            </h2>

            <p class="card-text"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gift" viewBox="0 0 16 16">
            <path d="M3 2.5a2.5 2.5 0 0 1 5 0 2.5 2.5 0 0 1 5 0v.006c0 .07 0 .27-.038.494H15a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 1 14.5V7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h2.038A2.968 2.968 0 0 1 3 2.506V2.5zm1.068.5H7v-.5a1.5 1.5 0 1 0-3 0c0 .085.002.274.045.43a.522.522 0 0 0 .023.07zM9 3h2.932a.56.56 0 0 0 .023-.07c.043-.156.045-.345.045-.43a1.5 1.5 0 0 0-3 0V3zM1 4v2h6V4H1zm8 0v2h6V4H9zm5 3H9v8h4.5a.5.5 0 0 0 .5-.5V7zm-7 8V7H2v7.5a.5.5 0 0 0 .5.5H7z"/>
          </svg> <?php if($numb == 1) echo 'Donation today';else echo 'Donations today'; ?></p>

            <p class="card-text"><small class="text-muted"> <a type="button" class="btn btn-sm btn-outline-secondary" href="/donation">View Details &rarr;</a></small></p>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <h2 class="card-title">{{ number_format(count($patients)) }}</h2>
            <p class="card-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pin-angle-fill" viewBox="0 0 16 16">
            <path d="M9.828.722a.5.5 0 0 1 .354.146l4.95 4.95a.5.5 0 0 1 0 .707c-.48.48-1.072.588-1.503.588-.177 0-.335-.018-.46-.039l-3.134 3.134a5.927 5.927 0 0 1 .16 1.013c.046.702-.032 1.687-.72 2.375a.5.5 0 0 1-.707 0l-2.829-2.828-3.182 3.182c-.195.195-1.219.902-1.414.707-.195-.195.512-1.22.707-1.414l3.182-3.182-2.828-2.829a.5.5 0 0 1 0-.707c.688-.688 1.673-.767 2.375-.72a5.92 5.92 0 0 1 1.013.16l3.134-3.133a2.772 2.772 0 0 1-.04-.461c0-.43.108-1.022.589-1.503a.5.5 0 0 1 .353-.146z"/>
          </svg> Patients</p>
            <p class="card-text"><small class="text-muted"><a type="button" class="btn btn-sm btn-outline-secondary" href="/patients">View Details &rarr;</a></small></p>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <h2 class="card-title">

                <!--  calculating total amount collected -->
                <?php 

                    $amount2 = 50000000;
                    foreach($donations as $donation){
                        if(substr($donation->created_at,0,7) == date('Y-m')){
                            $amount2 = $donation->amount + $amount2;
                        }
                    }
                    
                    echo  number_format($amount2).' Ugx!';
                

                ?>
                        
            </h2>
            <p class="card-text">Recieved This Month</p>
            <p class="card-text"><small class="text-muted"><p class="card-text"><small class="text-muted">

                      <!--  calculating total amount collected in current month -->

                      <?php 

                          $amount3 = 50000000;
                          foreach($donations as $donation){
                              $amount3 = $donation->amount + $amount3;
                          }

                          echo  number_format($amount3).' Ugx in total!';
                          

                      ?>
            </small></p>
          </div>
        </div>

      </div>   

    <div class="card-group">
      <div class="card">
        <div class="card-header" style="background: white;">
            <h5 class="card-title"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bar-chart-line" viewBox="0 0 16 16">
            <path d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1V2zm1 12h2V2h-2v12zm-3 0V7H7v7h2zm-5 0v-3H2v3h2z"/>
          </svg> Approx
             
                    <?php 


                        // Donations made this month

                        $amount = 50000000;
                        foreach($donations as $donation){
                            if(substr($donation->created_at,0,7) == date('Y-m')){
                                $amount = $donation->amount + $amount;
                            }
                        }
                        if(strlen($amount) > 2 && strlen($amount) <= 3){
                            echo substr($amount,0,-2).' hundred shillings!';
                        }
                        else if(strlen($amount) > 3 && strlen($amount) <= 6){
                            echo substr($amount,0,-3).' thousand shillings!'; 
                        }else if(strlen($amount) > 6 && strlen($amount) <= 12){
                            echo substr($amount,0,-6).' million shillings!'; 
                        }else if(strlen($amount) > 12 && strlen($amount) <= 18){
                            echo substr($amount,0,-12).' billion shillings!';
                        }else if(strlen($amount) > 18){
                            echo substr($amount,0,-18).' trillion shillings!';
                        }else{
                            echo  ' '.$amount. ' ';
                        }

                    ?>

                    collected this month.
             </h5>
        </div>
        <div class="card-body">
              <p class="card-text"><canvas id="userChart" class="shadow-sm"></canvas></p>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Pending Promotions:</h5>
          <p class="card-text">
              <ul class="promotions">

                    <!-- Getting eligible staff  -->

                    <?php 

                        
                        $names = array();

                        $names2 = array();

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

                                $x = $staff->staff_firstname.' '.$staff->staff_lastname;

                                if(!in_array($x, $names))
                                   $names[] = $x;

                            }else if($numb >= 900 && $staff->position == 'Senior Health Officer'){

                                $y = $staff->staff_firstname.' '.$staff->staff_lastname;

                                if(!in_array($y, $names2))
                                   $names2[] = $y;

                            }

                        }

                        // checking if there are any health officers/Senio H/O
                        // who reached a certain number of patients

                        if(count($names) > 0){
                            foreach($names as $name){
                                 echo '<li>'.$name.'</li>';
                            }
                        }
                        if(count($names2) > 0){
                            foreach($names2 as $name){
                             echo '<li>'.$name.'</li>';
                            }
                        }
                        if(count($names2) == 0 && count($names) == 0){
                            echo '<li>None</li>';
                        }                  

                    ?>

                  </ul>
                </p>  
        </div>
        <div class="card-footer" style="background: white; border: none">
            <a href="/confirm_promotions" type="button" class="btn btn-primary" style="width:100%;">Confirm <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-square" viewBox="0 0 16 16">
            <path d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5H3z"/>
            <path d="M8.354 10.354l7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z"/>
            </svg></a>
        </div>
      </div>
    </div>
      

      <!-- CHART-->

<script>
    var ctx = document.getElementById('userChart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'bar',
// The data for our dataset

        data: {
            labels:  {!!json_encode($chart->labels)!!} ,
            datasets: [
                {
                    label: 'Donation Per Month',
                    backgroundColor: {!! json_encode($chart->colours)!!} ,
                    data:  {!! json_encode($chart->dataset)!!} ,
                },
            ]
        },

// Configuration options go here
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false,
                        callback: function(value) {if (value % 1 === 0) {return value;}}
                    },
                    scaleLabel: {
                        display: false
                    }
                }]
            },
            legend: {
                labels: {
                    // This more specific font property overrides the global property
                    fontColor: '#122C4B',
                    fontFamily: "'Muli', sans-serif",
                    padding: 25,
                    boxWidth: 25,
                    fontSize: 14,
                }
            },
            layout: {
                padding: {
                    left: 10,
                    right: 10,
                    top: 0,
                    bottom: 10
                }
            }
        }
    });

    var list = document.getElementsByTagName('li')
    
    for(var x = 0; x < list.length; x++){
      if(x % 2 == 0){
         list[x].style.color = "#000000";
      }
    }

</script>



@endsection

