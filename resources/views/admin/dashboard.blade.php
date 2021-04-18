@extends('admin.includes.app')

@section('title')
    Natalpro | Admin | Dashboard
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">Dashboard</h3>
            </div>
        </div>
        
        <div style="margin:20px">
            <h2> Welcome back, Administrator  </h2>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('admin.vaccination.index') }}">
                        <div class="card btn btn-info">
                            <div class="card-body">
                                <!-- Row -->
                                <div class="row">
                                    <div class="col-8">
                                        <h2 style="color:#fff">{{ $vaccinations->count() }} </h2>
                                        <h6 style="color:#fff"> Vaccination Requests </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>  
                </div>

                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('admin.users.type') }}">
                        <div class="card btn btn-default">
                            <div class="card-body">
                                <!-- Row -->
                                <div class="row">
                                    <div class="col-8">
                                        <h2 style="color:#000">{{ $users->count() }} </h2>
                                        <h6 style="color:#000"> Users </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>  
                </div>
            </div>

            <div class="row">
                @if($users->count() == 0) 
                    <div class="container">
                        <div class="alert alert-danger"> No user yet </div>
                    </div>
                @else

                <div class="container">
                    <h3> Recent Users </h3> 
                </div>
                
                @foreach($users as $user)
                    <div class="col-md-6 col-lg-6 col-xlg-4">
                        <div class="card card-body">
                            <div class="row">
                                <div class="col-md-4 col-lg-3 text-center">
                                    <a href="#">
                                        <img src="{{ URL::asset('/images/avatar.png') }}" class="img-responsive img-circle" style="max-width:100px;max-height:100px"/>
                                    </a>
                                </div>
                                <div class="col-md-8 col-lg-9">
                                    <h3 class="box-title m-b-0">
                                        <a href="#" class="text-info"> {{ $user['full_name'] }} </a>
                                    </h3> <p></p>
                                    <small> {{ $user['location'] }} </small>
                                    <br/> <p></p>
                                    <small> 
                                        <a href="tel:{{ $user['phone_number'] }}"><i class="fa fa-phone"></i> {{ $user['phone_number'] }} </a> &nbsp; &nbsp; <a href="mailto:{{ $user['email_address'] }}"><i class="fa fa-envelope"></i> {{ $user['email_address'] }} </a>
                                    </small>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <br/><br/><br/>
            @endif
        </div>
        @include('admin.includes.footer')
    </div>
</div>
    
@endsection
