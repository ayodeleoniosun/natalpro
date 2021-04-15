@extends('login_app')

@section('title')
    Natalpro | Login
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

                    <form class="form-horizontal" id="login-form" action="#" method="post" onsubmit="return false">
                        
                        {{csrf_field()}}

                        <h3 class="box-title m-b-20" align="center">User Login </h3>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="login_id" required="" placeholder="Email address or Phone number"> </div>

                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" name="password" required="" placeholder="Password"> </div>
                        </div>
                        <!-- <div class="form-group">
                            <div class="col-xs-12">
                                <small> Login as </small> <br/>
                                <input name="login_as" type="radio" id="natal-nurse" value="natal-nurse"/>
                                <label for="natal-nurse">Natal Nurse</label> &nbsp; &nbsp;
                                <input name="login_as" type="radio" id="patient" value="pregnant-nursing-women"/>
                                <label for="patient">Pregnant / Nursing Mothers</label>
                            </div>
                        </div>
 -->
                        <!-- <div class="form-group">
                            <div class="col-md-12">
                                <div class="checkbox checkbox-primary pull-left p-t-0">
                                    <input id="checkbox-signup" type="checkbox">
                                    <label for="checkbox-signup"> Remember me </label>
                                </div> 
                                <br/>
                        </div> -->

                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button type="submit" style="background-color:#31516E;border:1px solid #31516E" class="btn btn-info btn-md btn-block" id="login-btn" onclick="return ajaxFormRequest('#login-btn','#login-form','/portal/sign-in','POST','#login-status','Login','no')">Login <i class="fa fa-sign-in"></i></button> <br/>
                                <div id='login-status' align='center'></div>
                            </div>
                        </div>
                        <div class="form-group m-b-0">
                            <div class="col-sm-12">
                                <a href="{{ route('Register') }}" class="text-info m-l-5"><i class="fa fa-user m-r-5"></i> Join Us!</a> 
                                <a href="#" class="text-info pull-right"><i class="fa fa-lock m-r-5"></i> Forgot password?</a> </div>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


@endsection
