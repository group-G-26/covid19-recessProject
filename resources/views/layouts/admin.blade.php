<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'COVID-19 CASE MANAGEMENT & REPORTING TOOL UGANDA') }}</title>


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style type="text/css">
        .page{
            color:blue;
        }
        .page:hover{
            background: #fff;
            color: blue;
        }
        .noRecords{
           color: red; 
        }

        .btn{
           border-radius: 0 0 0 0; 
        }
        .search-btn{
            border-radius: 0 10px 10px 0;
        }
        .search-field{
            border-radius: 10px 0 0 10px;
        }
        .navbar-brand{
            font-size: 12px;
        }
        .promotions{
            max-height: 200px;
            overflow-y: scroll;
        }
        .promotions li{
            list-style: decimal;
            font-size: 12px;
            letter-spacing: 1px;
            line-height: 30px;
        }
        @media(max-width: 600px){
          .respond{
              display: none;
          }
        }
    </style>

    

</head>
<body >

    <nav class="navbar navbar-light bg-light shadow-sm">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample01" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <a class="navbar-brand" href="{{ url('/home') }}">
          <img width="30px" height="30px" src="{{ asset('images/ministryofhealth.png') }}"> COVID-19 CASE MANAGEMENT AND REPORTING TOOL
      </a>

          
            
      <p>logged in as {{ Auth::user()->name }}
         <a href="/logout" type="button" class="btn btn-primary">Logout <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
          <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
        </svg></a>
      </p>
            
      <div class="collapse navbar-collapse" id="navbarsExample01">
        <center><ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="/home">HOME<span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/staff">STAFF</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="/patients" tabindex="-1">PATIENTS</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="/hospitals" tabindex="-1">HOSPITALS</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="/donation" tabindex="-1">DONATIONS</a>
          </li>
        </ul></center>
      </div>
    </nav>
    <main class="py-4">
        @yield('content')
    </main>
</body>
</html>
