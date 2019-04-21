<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <!--<link href="{{ asset('css/milligram.min.css') }}" rel="stylesheet">-->
    <!--<link href="{{ asset('css/app.css') }}" rel="stylesheet">-->
    
   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Calendar Icon-->
    <link rel="stylesheet" href="../css/calendar.css" type="text/css">

    <!-- Member Icon-->
    <link rel="stylesheet" href="../css/member.css" type="text/css">

    <!-- Modal View-->
    <link rel="stylesheet" href="../css/modal.css" type="text/css">

    <!-- Event Page-->
    <link rel="stylesheet" href="../css/event.css" type="text/css">

    <!-- Log In -->
    <link rel="stylesheet" href="../css/initial-page.css" type="text/css">

    <!-- Profile -->
    <link rel="stylesheet" href="../css/profile.css" type="text/css">

    <!-- Log In -->
    <link rel="stylesheet" href="../css/home-dash.css" type="text/css">

    <!-- Groups listing -->
    <link rel="stylesheet" href="../css/groups-listing.css" type="text/css">

    <!-- Notifications -->
    <link rel="stylesheet" href="../css/notification.css" type="text/css">

    <!-- Admin -->
    <link rel="stylesheet" href="../css/admin.css" type="text/css">

    <!-- Faq -->
    <link rel="stylesheet" href="../css/faq.css" type="text/css">

    <!-- Create group -->
    <link rel="stylesheet" href="../css/create-group.css" type="text/css">

    <!-- Section Manage -->
    <link rel="stylesheet" href="../css/section-manage.css" type="text/css">


    <!-- Search -->
    <link rel="stylesheet" href="../css/search.css" type="text/css">

    <!-- About -->
    <link rel="stylesheet" href="../css/about.css" type="text/css">

    <!-- Common -->
    <link rel="stylesheet" href="../css/common.css" type="text/css">

    <!-- FontAwesome-->
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr"
        crossorigin="anonymous"> -->
    <link rel="stylesheet" href="../fontawesome/css/all.min.css" type="text/css">

    <link
        href="https://fonts.googleapis.com/css?family=Acme|Francois+One|Indie+Flower|Josefin+Sans|Permanent+Marker|Quicksand|Sniglet|Rock+Salt"
        rel="stylesheet">



    <link href="https://fonts.googleapis.com/css?family=Noto+Sans|Nunito|PT+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC|Barrio|Kite+One|Questrial|Snippet" rel="stylesheet">

    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
    <script type="text/javascript" src={{ asset('js/app.js') }} defer>
</script>
  </head>
  <body>
    <main>
      <header>
        <h1><a href="{{ url('/cards') }}">Agrupa!</a></h1>
        @if (Auth::check())
        <a class="button" href="{{ url('/logout') }}"> Logout </a> <span>{{ Auth::user()->name }}</span>
        @endif
      </header>
      <section id="content">
        @yield('content')
      </section>
    </main>
  </body>
</html>
