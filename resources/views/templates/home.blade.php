<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Khóa luận tốt nghiệp</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="{{url('css/font-awesome.min.css')}}">

    <link rel="stylesheet" href="{{url('css/style.default.css')}}">

    link rel="stylesheet" href="{{url('css/daterangepicker.css')}}">
</head>
<body>
<div class="page">
    <header class="header">
        <nav class="navbar">
            <div class="search-box">
                <button class="dismiss"><i class="icon-close"></i></button>
                <form id="searchForm" action="#" role="search">
                    <input type="search" placeholder="What are you looking for..." class="form-control">
                </form>
            </div>
            <div class="container-fluid">
                <div class="navbar-holder d-flex align-items-center justify-content-between">
                    <div class="navbar-header">
                            <div class="brand-text brand-big"><span>Báo cáo khóa luận tốt nghiệp </span><strong> 2018 </strong></div>
                    </div>
                    <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                        <!-- Search-->
                        <li class="nav-item d-flex align-items-center"><a id="search" href="#"><i class="fa fa-search"></i></a></li>
                        <!-- Notifications-->
                        <li class="nav-item dropdown"> <a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-bell"></i><span class="badge bg-red">12</span></a>
                            <ul aria-labelledby="notifications" class="dropdown-menu">
                                <li><a rel="nofollow" href="#" class="dropdown-item">
                                        <div class="notification">
                                            <div class="notification-content"><i class="fa fa-envelope bg-green"></i>You have 6 new messages </div>
                                            <div class="notification-time"><small>4 minutes ago</small></div>
                                        </div></a></li>
                                <li><a rel="nofollow" href="#" class="dropdown-item">
                                        <div class="notification">
                                            <div class="notification-content"><i class="fa fa-twitter bg-blue"></i>You have 2 followers</div>
                                            <div class="notification-time"><small>4 minutes ago</small></div>
                                        </div></a></li>
                                <li><a rel="nofollow" href="#" class="dropdown-item">
                                        <div class="notification">
                                            <div class="notification-content"><i class="fa fa-upload bg-orange"></i>Server Rebooted</div>
                                            <div class="notification-time"><small>4 minutes ago</small></div>
                                        </div></a></li>
                                <li><a rel="nofollow" href="#" class="dropdown-item all-notifications text-center"> <strong>view all notifications                                            </strong></a></li>
                            </ul>
                        </li>
                        <!-- Messages                        -->
                        <li class="nav-item dropdown"> <a id="messages" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-envelope"></i><span class="badge bg-orange">10</span></a>
                            <ul aria-labelledby="notifications" class="dropdown-menu">
                                <li><a rel="nofollow" href="#" class="dropdown-item d-flex">
                                        <div class="msg-profile"> <img src="{{url('img/avatar.jpg')}}" alt="..." class="img-fluid rounded-circle"></div>
                                        <div class="msg-body">
                                            <h3 class="h5">Jason Doe</h3><span>Sent You Message</span>
                                        </div></a></li>
                                <li><a rel="nofollow" href="#" class="dropdown-item d-flex">
                                        <div class="msg-profile"> <img src="{{url('img/avatar.jpg')}}" alt="..." class="img-fluid rounded-circle"></div>
                                        <div class="msg-body">
                                            <h3 class="h5">Frank Williams</h3><span>Sent You Message</span>
                                        </div></a></li>
                                <li><a rel="nofollow" href="#" class="dropdown-item d-flex">
                                        <div class="msg-profile"> <img src="{{url('img/avatar.jpg')}}" alt="..." class="img-fluid rounded-circle"></div>
                                        <div class="msg-body">
                                            <h3 class="h5">Ashley Wood</h3><span>Sent You Message</span>
                                        </div></a></li>
                                <li><a rel="nofollow" href="#" class="dropdown-item all-notifications text-center"> <strong>Read all messages    </strong></a></li>
                            </ul>
                        </li>
                        <!-- Logout    -->
                        <li class="nav-item"><a href="{{route('_logout')}}" class="nav-link logout">Logout  <i class="fa fa-sign-out-alt"></i></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="page-content d-flex align-items-stretch">
        <nav class="side-navbar">
            <!-- Sidebar Header-->
            <div class="sidebar-header d-flex align-items-center">
                <div class="avatar"><img src="{{url('img/avatar.jpg')}}" alt="..." class="img-fluid rounded-circle"></div>
                <div class="title">
                    <h1 class="h4">Ngô Phương Tuấn</h1>
                    <p>K59 CLC</p>
                </div>
            </div>
            <span class="heading">Main</span>
            <ul class="list-unstyled">
                <li class="active"><a href="{{url(route('home'))}}"> <i class="fa fa-home"></i>Trang chủ </a></li>
                <li class="active"><a href="{{url(route('keyword'))}}"> <i class="fa fa-key"></i>Từ khóa </a></li>
                <li class="active"><a href="{{url(route('info'))}}"> <i class="fa fa-id-card-o"></i>Thông tin cá nhân </a></li>

                <?php
                 $user = Auth::user();
                 if($user->type == \App\User::SUPER_ADMIN_TYPE || $user->type == \App\User::ADMIN_TYPE) {
                     echo "<li class='active'><a href='".route('manage')."'> <i class='fa fa-user-o'></i>Quản lý nhân sự</a></li>";
                     echo "<li class='active'><a href='".route('diary')."'> <i class='fa fa-user-o'></i>Quản lý lịch sử sử dụng</a></li>";
                 }
                 if($user->type == \App\User::SUPER_ADMIN_TYPE) echo "<li class='active'><a href='".route('approve')."'> <i class='fa fa-user-plus'></i>Xác thực người dùng</a></li>";
                ?>
            </ul>
        </nav>
        <div class="content-inner">
            <header class="page-header">
                <div class="container-fluid">
                    <h2 class="no-margin-bottom">
                        @yield('title')
                    </h2>
                </div>
            </header>

            <section class="dashboard-counts no-padding-bottom">
                @yield('content')
            </section>

            <footer class="main-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <p>Khóa luận tốt nghiệp &copy; 2014-2018</p>
                        </div>
                        <div class="col-sm-6 text-right">
                            <p>Design by <a href="https://bootstrapious.com/admin-templates" class="external">Ngô Phương Tuấn</a></p>
                            <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>
<!-- Javascript files-->
<script src="{{url('js/jquery-3.3.1.min.js')}}"></script>
<script src="{{url('js/popper.min.js')}}"> </script>
<script src="{{url('js/canvasjs.min.js')}}"> </script>
<script src="{{url('js/bootstrap.min.js')}}"></script>
<script src="{{url('js/moment.min.js')}}"></script>
<script src="{{url('js/daterangepicker.js')}}"></script>
@yield('after-script')
</body>
</html>