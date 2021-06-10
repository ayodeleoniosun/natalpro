@extends('user.template')

@section('title')
    Natalpro | User Login
@endsection

@section('content')
    <section id="wrapper">
        <div class="login-register" style="background-image:url(/assets/images/background/login-register.jpg); background-size:cover;">
            <div class="the-login-box card">
                <div class="card-body">
                    <div align="center">
                        <img src="{{ URL::asset('assets/images/logo-icon.png')}}" alt="homepage" class="dark-logo" class="img-responsive img-thumbnail"/>
                    </div>
                    <br/>
                    <h3 class="box-title m-b-20" align="center">User Login</h3>
                    <div class="flash-message">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session('alert-' . $msg))
                                <div class="container">
                                <div class="col-sm-12">
                                    <div class="alert alert-{{ $msg }} alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    {{ Session('alert-' . $msg) }}
                                    </div>
                                </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    
                    <form class="form-horizontal" action="{{ route('user.login') }}" method="post">
                        {{csrf_field()}}
                        <div class="form-group ">
                            <div class="col-xs-12">
                            <input class="form-control" type="text" name="username" required="" placeholder="Phone Number"> </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" name="password" required="" placeholder="Password"> 
                            </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-info btn-md btn-block">Login <i class="fa fa-sign-in"></i></button> 
                            </div>
                        </div>
                    </form>
                    <div class="pull-left"> <a href="{{ route('vaccination.add') }}" class="text-info"> Sign up for vaccination </a> </div>
                
                    <div class="pull-right"> <a href="{{ route('index') }}" class="text-info"><i class="fa fa-arrow-circle-left"></i> Back to Home</a> </div>
                
                </div>
            </div>
        </div>
    </section>
@endsection