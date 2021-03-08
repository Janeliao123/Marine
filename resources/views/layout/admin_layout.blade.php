<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <title></title>
    {{-- mete區 --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- 引入Styles --}}
    <link rel="stylesheet" href="/css/home.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="/css/admin.css" rel="stylesheet">
    <style media="screen">
    body{
      font-family: 微軟正黑體;
      background-color:#f8f8f8;
      width: 100%;
    }
    .navbar {
        margin: 0;
        width: 100%;
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
    <section>
      <!-- Left Sidebar -->
      <div>
      <aside id="mySidenav" class="sidebar">
          <a href="javascript:void(0)" class="closebtn" onclick="closeNav()" ><span class="glyphicon glyphicon-remove" style="margin-left:95%"></span></a>
          <!-- User Info -->
          <div class="user-info">
              <center><div class="info-container">
                  <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{Auth::guard('admin')->user()->name}}</div>
                  <div class="email">{{Auth::guard('admin')->user()->email}}</div>
              </div></center>
          </div>
          <!-- #User Info -->
          <!-- Menu -->
          <div class="menu">
              <ul class="list" ><hr>
                @if(Auth::guard('admin')->user()->email == "admin@example.com")
                  <li>
                    <a  href="{{ route('admin.register') }}">
                        {{ __('註冊新教師') }}
                    </a>
                  </li><hr>
                @endif
                  <li>
                    <a href="{{ url('admin') }}">後臺首頁</a>
                  </li><hr>
                  <li class="header">班級管理</li><hr>
                  <li>
                    <a href="{{ url('admin/user_lists') }}">班級管理</a>
                  </li><hr>
                  <li class="header">後臺管理</li><hr>
                  <li>
                      <a href="{{ url('admin/chapter') }}">章管理</a>
                  </li><hr>
                  <li>
                      <a href="{{ url('admin/section') }}">節管理</a>
                  </li><hr>
                  <li>
                      <a href="{{ url('admin/question') }}">題目管理</a>
                  </li><hr>

              </ul><br><br><br><br><br><br><br><br><br><br>
          </div>

      </aside>
    </div>
      <!-- #END# Left Sidebar -->
      <!-- Right Sidebar -->

      <!-- #END# Right Sidebar -->
    </section>

    <section class="content">
      <span id="open_btn" style="font-size:30px;cursor:pointer;position:absolute;left:25px" onclick="openNav()">&#9776;</span>
      <div class="container">
        @yield('content')
      </div>
    </section>
    {{-- JavaScripts --}}
    <script type="text/javascript">

        function openNav() {
          var $body = $('body');
          document.getElementById("mySidenav").style.width = "300px";
          $body.removeClass('ls-closed');
        }
        function close_btn() {
          document.getElementById("open_btn").style.left = "10px";
        }

        function closeNav() {
          var $body = $('body');
          document.getElementById("mySidenav").style.width = "0";
          $body.addClass('ls-closed');

        }

    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="/js/admin.js"></script>
    @yield('js')
</body>
</html>
