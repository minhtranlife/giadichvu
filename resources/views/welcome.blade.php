<!DOCTYPE html>
<html lang="en">
<head>
    <title>CSDL về giá</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="Thu, 19 Nov 1900 08:52:00 GMT">
    <!--link rel="shortcut icon" href="images/icons/loading.gif" type="image/x-icon"-->
    <link rel="shortcut icon" href="{{ url('images/LIFESOFT.png')}}" type="image/x-icon">
    <!--Loading bootstrap css-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700&subset=vietnamese' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{url('vendors/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{url('vendors/bootstrap/css/bootstrap.min.css')}}">
    <!--LOADING STYLESHEET FOR PAGE-->
    <link rel="stylesheet" href="{{url('vendors/select2/select2-madmin.css')}}">
    <link rel="stylesheet" href="{{url('vendors/bootstrap-select/bootstrap-select.min.css')}}">
    <link rel="stylesheet" href="{{url('vendors/multi-select/css/multi-select-madmin.css')}}">
    <link rel="stylesheet" href="{{url('vendors/jquery-notific8/jquery.notific8.min.css')}}">

    <!--Loading style vendors-->
    <link rel="stylesheet" href="{{url('vendors/animate.css/animate.css')}}">
    <link rel="stylesheet" href="{{url('vendors/iCheck/skins/all.css')}}">
    <!--Loading style-->
    <link rel="stylesheet" href="{{url('css/themes/style1/zvinhtq.css')}}" class="default-style">
    <link rel="stylesheet" href="{{url('css/style-responsive.css')}}">
    <link rel="stylesheet" href="{{url('images/icons/favicon.ico')}}" rel="shortcut icon">
</head>
<body id="home-page" class="text-center">

<br><br>
<div class="row">
    <img src="{{url('images/LIFESOFT.png')}}" width="250" alt="Công ty TNHH phát triển phần mềm Cuộc Sống">
</div>
<div class="row">
    <h3><b></b></h3>
</div>
<div class="row mbl">
    <br>
    <br>
    <br>
    <h1><b>PHẦN MỀM CƠ SỞ DỮ LIỆU VỀ GIÁ</b></h1>
    <h5><b><i>(Phân hệ quản lý giá dịch vụ)</i></b></h5>

    <br>
</div>
<div class="row mbxl">
    <a href="{{ url('/login') }}" class="btn btn-primary btn-lg">Đăng nhập tài khoản</a>&nbsp;
    <a href="{{ url('/giadichvu') }}" class="btn btn-blue btn-lg" target="_blank">Trang công bố giá</a>&nbsp;
    <a href="{{ url('/search_register') }}"> <h5 style="color: blue"><i><u> Kiểm tra tài khoản đã đăng ký</u></i></h5></a>
    <a href="{{ url('/thongtinhotro') }}" target="_blank"> <h5 style="color: blue"><i><u> Thông tin hỗ trợ</u></i></h5></a>


</div>
<br>
<br>
<br>
<hr class="mtxl mbxl">
<div class="row">

    <div class="col-md-12 footer-block" style="text-align: center">
        <p>Bản quyền thuộc về &nbsp;<b>{{isset(getGeneralConfigs()['tendonvi']) ? getGeneralConfigs()['tendonvi'] : ''}}</b></p>
        <p>Địa chỉ: &nbsp;<b>{{isset(getGeneralConfigs()['diachi']) ? getGeneralConfigs()['diachi'] : ''}}</b></p>
        <p>Thông tin liên hệ: &nbsp;<b>{{isset(getGeneralConfigs()['tel']) ? getGeneralConfigs()['tel'] : ''}}</b></p>
    </div>
</div>

<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<!--loading bootstrap js-->
<script type="text/javascript" src="vendors/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="vendors/bootstrap-hover-dropdown/bootstrap-hover-dropdown.js"></script>
<script type="text/javascript" src="vendors/jquery-validate/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/html5shiv.js"></script>
<script type="text/javascript" src="js/respond.min.js"></script>
<script type="text/javascript" src="js/extra-signup.js"></script>
<script type="text/javascript" src="vendors/iCheck/icheck.min.js"></script>
<script type="text/javascript" src="vendors/iCheck/custom.min.js"></script>
<!--LOADING SCRIPTS FOR PAGE-->
</body>
</html>