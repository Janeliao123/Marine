<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <title></title>
    {{-- mete區 --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- 引入Styles --}}
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('/css/home.css')}}">
    <style media="screen">
    body{
      font-family: 微軟正黑體;
      background-color:#f8f8f8;
      width: 100%;
    }
    .navbar {
        margin: 0;
        width: 100%;
        padding-top: 15px;
        padding-bottom: 15px;
        border: 0;
        border-radius: 0;
        margin-bottom: 0;
        font-size: 15px;
        letter-spacing: 5px;
        background-color:#fff;

     }
    </style>
    @yield('css')

</head>
<body>

    @include('layout.navbar')

    <main>
        @yield('content')
        <img style="position:fixed;right:2%;bottom:5%" src="img/logo1.png">
    </main>
    {{-- JavaScripts --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    @yield('js')
</body>
</html>
