<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>NatalPro | Admin Login</title>
    <link href="{{ URL::asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet">
    <script src="{{ URL::asset('assets/plugins/jquery/jquery.min.js') }}"></script>    
</head>

<body>
    <section id="wrapper">
        <div class="login-register" style="background-image:url(/assets/images/background/login-register.jpg); background-size:cover;">
            <div class="the-login-box card">
                <div class="card-body">
                    <div align="center">
                        <img src="{{ URL::asset('assets/images/logo-icon.png')}}" alt="homepage" class="dark-logo" class="img-responsive img-thumbnail"/>
                    </div>
                    <br/>
                    <form class="form-horizontal" id="admin-login-form" action="#" method="post" onsubmit="return false">
                        {{csrf_field()}}
                        <h3 class="box-title m-b-20" align="center">Admin Login</h3>
                        <div class="form-group ">
                            <div class="col-xs-12">
                            <input class="form-control" type="email" name="email" required="" placeholder="Email address"> </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" name="password" required="" placeholder="Password"> 
                            </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-info btn-md btn-block" id="admin-login-btn" onclick="return ajaxFormRequest('#admin-login-btn','#admin-login-form','/admin','POST','#admin-login-status','Login','no')">Login <i class="fa fa-sign-in"></i></button> <br/>
                                <div id='admin-login-status'></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <script src="{{ URL::asset('js/natalpro.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
</body>

</html>