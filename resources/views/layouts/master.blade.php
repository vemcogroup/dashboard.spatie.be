<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,900'
          rel='stylesheet'
          type='text/css'>
    <link href="{{ mix("css/app.css") }}" rel="stylesheet"/>
    <meta name="google" value="notranslate">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

    @yield('content')

    <script src="{{ mix("js/app.js") }}"></script>

</body>
</html>
