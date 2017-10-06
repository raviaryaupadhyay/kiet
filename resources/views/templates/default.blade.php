<! Document html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>kietbook</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}" >

  </head>
  <body>
    @include('templates.partials.navigation')
    <div class="container">
      @include('templates.partials.alerts')
      @yield('content')
  </body>
