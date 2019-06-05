<nav class="navbar navbar-sticky-top navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/trang-chu" style="margin-left: 80px:color:#DBBABA"><h3>TravelingHub</h3></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            {{-- <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown">
                    Plan Travel
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li> --}}.
            
        </ul>
        <ul class="navbar-nav margin-left">
            
            @if(Auth::check())
            <li class="nav-item">
                <a class="nav-link" href="/thong-tin-ca-nhan/{{Auth::user()->id}}">
                    {{Auth::user()->full_name}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/logout">Đăng xuất</a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="/login">Đăng nhập</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/register">Đăng ký</a>
            </li>
            @endif
        </ul>
    </div>
</nav>