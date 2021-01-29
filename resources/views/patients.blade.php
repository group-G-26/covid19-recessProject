@extends('layouts.admin')

@section('content')

<center><h2 class="pageTitle"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pin-angle-fill" viewBox="0 0 16 16">
  <path d="M9.828.722a.5.5 0 0 1 .354.146l4.95 4.95a.5.5 0 0 1 0 .707c-.48.48-1.072.588-1.503.588-.177 0-.335-.018-.46-.039l-3.134 3.134a5.927 5.927 0 0 1 .16 1.013c.046.702-.032 1.687-.72 2.375a.5.5 0 0 1-.707 0l-2.829-2.828-3.182 3.182c-.195.195-1.219.902-1.414.707-.195-.195.512-1.22.707-1.414l3.182-3.182-2.828-2.829a.5.5 0 0 1 0-.707c.688-.688 1.673-.767 2.375-.72a5.92 5.92 0 0 1 1.013.16l3.134-3.133a2.772 2.772 0 0 1-.04-.461c0-.43.108-1.022.589-1.503a.5.5 0 0 1 .353-.146z"/>
</svg> Patients</h2></center>

<div class="album py-0 bg-light">

<div class="container">

    

    <div class="row">
        <div class="col-md-12">

            <div style="float: left" >
                <a type="button" class="btn btn-secondary" href="/graphical"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bar-chart-line" viewBox="0 0 16 16">
                <path d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1V2zm1 12h2V2h-2v12zm-3 0V7H7v7h2zm-5 0v-3H2v3h2z"/>
              </svg> <span class="respond">Percentage Change</span></a>
            </div>

            <a href="/patients" type="button" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
            </svg> <span class="respond">Show all</span></a>
            <div style="float: right">
            <form class="" action="/search_patients" method="GET">
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
                    <th>Full Name</th>
                    <th>Date Enrolled</th>
                    <th>Category</tb>
                    <th>Reg. & Treat. By</tb>   
                </tr>
             @if(count($patients) > 0)
                @foreach($patients as $patient)
                <tr>
                    <td>{{ $patient->id }}</td>
                    <td>{{ $patient->pat_name }}</td>
                    <td>{{ $patient->date }}</td>
                    <td>{{ $patient->category }}</td>
                    <td>

                        <!-- Getting health officer -->

                        <?php

                            foreach($staffs as $staff){
                                if($patient->staff_id == $staff->id){
                                    echo $staff->staff_firstname.' '.$staff->staff_lastname;
                                }
                            }

                        ?>
                        <!--  -->


                    </td>
                </tr>
                @endforeach
                <tr>
                    <th colspan="5" class="page">
                        Showing page {{ $patients->currentPage() }} of {{ $patients->lastPage() }}
                    </th>
                </tr>
             @endif

             @if(count($patients) == 0)
                <tr>
                  <td colspan="5" class="noRecords">
                     No records inserted yet!
                  </td>
                </tr>
             @endif

            </table>
           </div>

            <div style="float: right">
                {{ $patients->links() }}
            </div>
           
          </div>

    </div>
</div>

@endsection