@extends('login_app')

@section('title')
    Natalpro | Forgot Password
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
                        <a href="http://www.natalpro.org">
                            <img src="{{ URL::asset('assets/images/logo-icon.png')}}" alt="homepage" class="dark-logo" class="img-responsive img-thumbnail"/>
                        </a>
                    </div>
                    <br/>

                    <form class="form-horizontal" id="forgot-password-form" action="#" method="post" onsubmit="return false">
                        
                        {{csrf_field()}}

                        <h3 class="box-title m-b-20" align="center">Reset Password</h3>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="email" name="email" required="" placeholder="Email address"> </div>

                        </div>
                        
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-info btn-md btn-block" id="forgot-password-btn" onclick="return ajaxFormRequest('#forgot-password-btn','#forgot-password-form','/portal/reset-password','POST','#forgot-password-status','Continue','no')">Continue <i class="fa fa-arrow-circle-right"></i></button> <br/>
                                <div id='forgot-password-status'></div>
                            </div>
                        </div>
                        <div class="form-group m-b-0">
                            <div class="col-sm-12">
                                <a href="{{ route('Register') }}" class="text-info m-l-5"><i class="fa fa-user m-r-5"></i> Join Us!</a> 
                                <a href="{{ route('Login') }}" class="text-info pull-right"><i class="fa fa-lock m-r-5"></i> Sign In</a> </div>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


@endsection
