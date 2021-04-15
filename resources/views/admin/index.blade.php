@extends('admin.login_app')

@section('title')
    Natalpro | Admin Login
@endsection

@section('content')
    <section id="wrapper">
        <div class="login-register" style="background-image:url(../portal/assets/images/background/login-register.jpg); background-size:cover;">
            <div class="the-login-box card">
                <div class="card-body">

                    @if(session('error'))
                        <div class='alert alert-danger'>
                            <i class="fa fa-remove"></i> {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class='alert alert-success'>
                            <i class="fa fa-check"></i> {{ session('success') }}
                        </div>
                    @endif

                    @php(Session::forget('success'))
                    @php(Session::forget('error'))
                    
                    
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
                                <input class="form-control" type="password" name="password" required="" placeholder="Password"> </div>
                        </div>
                        
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-info btn-md btn-block" id="admin-login-btn" onclick="return ajaxFormRequest('#admin-login-btn','#admin-login-form','/portal/controlling-room-admin/admin-sign-in','POST','#admin-login-status','Login','no')">Login <i class="fa fa-sign-in"></i></button> <br/>
                                <div id='admin-login-status'></div>

                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>


@endsection
