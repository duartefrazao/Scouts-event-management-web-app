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
    <script type="text/javascript" src={{ asset('js/app.js') }} defer></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"
            defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"
            defer></script>
    <script src="../bootstrap/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"
            defer></script>


    <!--<script src="//maps.googleapis.com/maps/api/js?libraries=places" type="text/javascript" defer></script>
    <script src="../js/map.js" type="text/javascript" defer></script>
    <script src="../js/home.js" type="text/javascript" defer></script>
    <script src="../js/member.js" type="text/javascript"></script>
    <script src="../js/event.js" type="text/javascript" defer></script>
    <script src="../js/group.js" type="text/javascript" defer></script>
    <script src="../js/profile.js" type="text/javascript" defer></script>
    <script src="../js/notification.js" type="text/javascript" defer></script>
    <script src="../js/admin.js" type="text/javascript" defer></script>
    <script src="../js/section-manage.js" type="text/javascript" defer></script>
    <script src="../js/search.js" type="text/javascript" defer></script>-->

    </head>
<body>
    <main>
        <header>
            @yield('navbar')
        </header>
        <section id="content">
            @yield('content')
        </section>
    </main>
</body>
</html>
