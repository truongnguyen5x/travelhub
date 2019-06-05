<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Du lịch bụi</title>

    <!-- Bootstrap core CSS -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="/bootstrap/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/bootstrap/css/jumbotron-narrow.css" rel="stylesheet">

    <link href="/css/style.css" rel="stylesheet">
    <link href="/font-awesome/css/all.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body style="background: #f4f4f4;">

    <div class="container-fluid" >
        <nav class="header bg-light navbar-light float-right text-center">
            <div style="display: inline-block;margin-top: 5px">
                @yield('search')
                <a class="nav-link" href="/trang-chu" style="display: inline; margin-top: 2px">
                    <h4 style="display: inline"><i class="fas fa-anchor"></i>TravelHub</h4>
                </a>
            </div>
            <ul style="float: right;display: block; margin: 5px 150px 0px 0px;">

                <li class="dropdown" style="display: inline-block">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" href="#">
                        <i class="fas fa-bell"></i> Thông báo<span class="badge">2</span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            {{--@foreach(Auth::user()->unreadNotifications as $notification)--}}
                            <a href="">fewfw</a>
                            {{-- @endforeach --}}
                        </li>
                    </ul>
                </li>
                <li style="display: inline-block">
                    <a class="nav-link" href="/thong-tin-ca-nhan/{{Auth::user()->id}}"><i class="fas fa-user"></i> Thông tin cá nhân</a>
                </li>
                <li style="display: inline-block">
                    <a class="nav-link" href="/logout"><i class="fas fa-sign-out-alt"></i> Đăng Xuất</a>
                </li>

            </ul>
        </nav>
        <section class="container-fluid" style="width: 75%;margin-top: 50px">
            @yield('content')
        </section>
    </div> <!-- /container -->
</body>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/js/jquery-3.3.1.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/bootstrap/js/bootstrap.js"></script>
</html>
