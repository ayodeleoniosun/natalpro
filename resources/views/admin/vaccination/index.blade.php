@extends('admin.includes.app')

@section('title')
    Natalpro | All Vaccination Reminder Requests
@endsection

@section('content') 
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">Vaccination Reminder Requests <span class="badge badge-info">{{ $vaccinations->count() }} </span></h3>
            </div>
        </div>

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
        
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    @if($vaccinations->count() == 0) 
                        <div class="alert alert-danger" style="margin:0 auto"> No vaccination reminder request yet </div>
                    @else
                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Mother</th>
                                        <th>Child</th>
                                        <th>Phone</th>
                                        <th>DOB</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach($vaccinations as $key => $vaccination)
                                        <tr>
                                            <td>{{ $key += 1 }}</td>
                                            <td><a href="{{ route('admin.vaccination.show', ['id' => $vaccination['id']]) }}"><b> {{ $vaccination['transaction_id'] }} </b></a></td>
                                            <td><a href="{{ route('admin.user.profile', ['id' => $vaccination['user_id']]) }}" class="text-info"> {{ $vaccination['user']['fullname'] }} </a></td>
                                            <td>{{ $vaccination['mother'] }}</td>
                                            <td>{{ $vaccination['child'] }}</td>
                                            <td><a href="tel:{{ $vaccination['user']['phone_number'] }}">{{ $vaccination['user']['phone_number']}}</a></td>
                                            <td>{{ $vaccination['dob'] }}</td>
                                            <td>{{ $vaccination['created_at'] }}</td>
                                            <td><span class="{{ $vaccination['status']['color'] }}"> {{ $vaccination['status']['label'] }} </span> </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br/>
                    @endif
                </div>
            </div>
        </div>

        @include('admin.includes.footer')
    </div>
</div>
    
@endsection
