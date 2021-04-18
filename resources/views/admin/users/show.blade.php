@extends('admin.includes.app')

@section('title')
    Natalpro | {{ $user['full_name'] }}'s Profile
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">{{ $user['full_name'] }}'s Profile</h3>
            </div>
        </div>
        
        <div class="container-fluid">
        <h2 class="add-ct-btn pull-left">
            <button onclick="return window.history.back()" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark">
            <i class="fa fa-arrow-circle-left"></i> Back</button>
        </h2>

        <div style="clear:both;"></div>

            <div class="row">
                <div class="col-lg-4 col-xlg-3 col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <center class="m-t-30"> 
                                <img src="{{ URL::asset('/images/avatar.png') }}" class="img-responsive img-circle" style="max-width:150px;max-height:150px"/>
                            </center>
                        </div>
                        <div>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="col-lg-8 col-xlg-9 col-md-7">
                    <div class="card">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs profile-tab" role="tablist">
                            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#personal" role="tab">Personal Details </a> </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="personal" role="tabpanel">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 col-xs-12 b-r"> <strong>Phone no</strong>
                                            <br>
                                            <p class="text-muted"> {{ $user['phone_number'] }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-xs-12 b-r"> <strong>Location</strong>
                                            <br>
                                            <p class="text-muted"> {{ $user['location'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>

                @if($user['vaccinations']->count() > 0) 
                    <div class="container-fluid">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-tabs profile-tab" role="tablist">
                                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#personal" role="tab">{{ $user['full_name'] }}'s Vaccination Requests <span class="btn btn-rounded btn-sm btn-info waves-effect waves-dark"> {{ $user['vaccinations']->count() }} </span></a> </li>
                                </ul>
                                <div class="table-responsive">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>ID</th>
                                                <th>Mother</th>
                                                <th>Child</th>
                                                <th>DOB</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            @foreach($user['vaccinations'] as $vaccination)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td><a href="{{ route('admin.vaccination.show', ['id' => $vaccination['id']]) }}"><b> {{ $vaccination['transaction_id'] }} </b></a></td>
                                                    <td>{{ $vaccination['mother'] }}</td>
                                                    <td>{{ $vaccination['child'] }}</td>
                                                    <td>{{ $vaccination['dob'] }}</td>
                                                    <td>{{ $vaccination['created_at'] }}</td>
                                                    <td><span class="{{ $vaccination['status']['color'] }}"> {{ $vaccination['status']['label'] }} </span> </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <br/>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

        @include('admin.includes.footer')
    </div>
</div>
    
@endsection
