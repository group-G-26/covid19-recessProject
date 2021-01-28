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

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style type="text/css">
        .btn{
           border-radius: 0 0 0 0; 
        }
        .navbar-brand{
            font-size: 12px;
        }
        body{

            background: url("{{ asset('images/coronavirus.jpg') }}");
           
            background-repeat: no-repeat;
            background-size: cover;
            min-height:100vh;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-light bg-light shadow-sm">

      <a class="navbar-brand" href="{{ url('/home') }}">
          <img width="30px" height="30px" src="{{ asset('images/ministryofhealth.png') }}"> COVID-19 CASE MANAGEMENT AND REPORTING TOOL
      </a>
              
    </nav>


        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
