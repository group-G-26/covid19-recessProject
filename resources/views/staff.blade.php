@extends('layouts.admin')

@section('content')


<center><h2 class="pageTitle"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
<path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
</svg> Staff</h2></center>

<div class="album py-0 bg-light">

    <div class="container">

     @if (session('success'))
        <div class="alert alert-success">
            <strong>   
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-emoji-smile-fill" viewBox="0 0 16 16">
                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zM4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683zM10 8c-.552 0-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5S10.552 8 10 8z"/>
              </svg> {{ session('success') }}
            </strong>
        </div>
     @endif

     

     <div class="row">
        <div class="col-md-12">
            <div style="float: left; display: flex;" >
                <a type="button" class="btn btn-secondary" href="/staff_reg_page">&plus; <span class="respond">Register Staff</span></a>
             
                <a href="/staff" type="button" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                </svg> <span class="respond">Show all</span></a>
             </div>
          


            <div style="float: right">
            <form class="" action="/search_staff" method="GET">
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
                    <table class="table table-bordered table-sm table-hover" >
                        <tr>
                            <th>Id</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Gender</th>
                            <th>Position</tb>
                            <th>Hospital attached</th>
                            <th>No. of patients</th>
                            <th>Salary recieved</th>
                            <th>Action</th>
                        </tr> 
                        
                        @if(count($staffs) > 0)
                            @foreach($staffs as $staff)
                            <tr>
                               <td>{{ $staff->id }}</td>
                               <td>{{ $staff->staff_firstname }}</td>
                               <td>{{ $staff->staff_lastname }}</td>
                               <td>{{ $staff->gender }}</td>
                               <td>{{ $staff->position }}</td>

                               <td>

                                   <!--  Getting hospital attached -->

                                   <?php
                                        foreach($hospitals as $hospital){
                                            if($staff->hos_id == $hospital->id){
                                                echo substr($hospital->name,0,30);
                                            }
                                        }

                                   ?>

                               </td>
                               <td>
                                   
                                  <!--  Calculation number of patients  -->

                                  <?php 

                                        $numb = 0;
                                        foreach($patients as $patient){
                                            if($staff->id == $patient->staff_id){
                                                $numb = $numb + 1;
                                            }
                                        }

                                        echo number_format($numb);

                                  ?>

                               </td>
                               <td>

                                   <!--  Salaries -->
                                  <?php


                                  if(date('j') == 28 || date('j') == 29 || date('j') == 30){

                                      $amount1 = 50000000;
                                      foreach($donations as $donation){
                                          if(substr($donation->created_at,0,7) == date('Y-m')){
                                              $amount1 = $donation->amount + $amount1;
                                          }
                                      }

                                      if($amount1 > 100000000){

                                          $dir = 5000000;

                                          $supre = 0.5 * $dir;
                                          $admin = 0.25 * $supre;
                                          $h_o = 1.6 * $admin;
                                          $s_h_o = $h_o + (0.06 * $h_o);
                                          $head_h_o = $h_o + (0.035 * $h_o);

                                          $all_deductions = $amount1 - ($supre + $admin + $h_o + $s_h_o + $head_h_o + $dir);

                                          if($staff->position == 'Director'){
                                              $dir = $dir + (0.05 * $all_deductions);
                                              echo number_format($dir);
                                          }
                                          if($staff->position == 'Administrator'){
                                              $admin = $admin + (0.25 * (0.025 * $all_deductions));
                                              echo number_format($admin);
                                          }
                                          if($staff->position == 'Supreintendant'){
                                              $supre = $supre + (0.025 * $all_deductions);
                                              echo number_format($supre);
                                          }
                                          if($staff->position == 'Health Officer'){
                                              echo number_format($h_o);
                                          }
                                          if($staff->position == 'Senior Health Officer'){
                                              echo number_format($s_h_o);
                                          }
                                          if($staff->position == 'Head Health Officer'){
                                              echo number_format($head_h_o);
                                          }


                                      }else{
                                          echo 'No salary paid!';
                                      }
                                    }else{
                                        echo 'Not paid yet';
                                    }


                                  ?>
                               </td>
                               <td>

                                    <a href="/delete_staff/{{ $staff->id }}" type="button" class="btn btn-danger"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                  </svg></a>

                                    <a href="/edit_staff/{{ $staff->id }}" type="button" class="btn btn-danger"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                    <path d="M13.498.795l.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
                                  </svg></a>

                               </td> 
                           </tr>
                           @endforeach
                           <tr>
                                <th colspan="9" class="page">
                                    Showing page {{ $staffs->currentPage() }} of {{ $staffs->lastPage() }}
                                </th>
                           </tr>
                        @endif

                        @if(count($staffs) == 0)
                            <tr>
                                <td colspan="7" class="noRecords">
                                    No records inserted yet
                                </td>
                            </tr>
                        @endif
                    </table>
                </div>
                <div style="float: right;">
                     {{ $staffs->links() }}
                </div>   
        </div>
    </div>
</div>



@endsection