@extends('user.includes.app')

@section('title')
    Natalpro | My Vaccination Reminder Requests
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
                                        <th>Mother</th>
                                        <th>Child</th>
                                        <th>Phone</th>
                                        <th>DOB</th>
                                        <th>Requested On</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach($vaccinations as $key => $vaccination)
                                        <tr>
                                            <td>{{ $key += 1 }}</td>
                                            <td>
                                                @if($vaccination->transaction_id)
                                                    <a href="{{ route('user.vaccination.show', ['id' => $vaccination->id, 'userType' => 'user']) }}"><b> {{ $vaccination->transaction_id }} </b></a>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $vaccination->mother }}</td>
                                            <td>{{ $vaccination->child }}</td>
                                            <td>{{ $vaccination->user->phone_number}}</td>
                                            <td>{{ $vaccination->dob }}</td>
                                            <td>{{ $vaccination->created_at }}</td>
                                            <td><span class="{{ $vaccination->status['color'] }}"> {{ $vaccination->status['label'] }} </span> </td>
                                            <td>
                                                @if($vaccination->status['label'] === 'Active') 
                                                    <a href="{{ route('user.vaccination.opt-out', ['id' => $vaccination->id]) }}" class="btn btn-sm btn-danger" onclick="return confirm('Opting out of this vaccination reminder will stop SMS from being sent to you until you register for another vaccination reminder. \n \n Opt out?')"> Opt out </a>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
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
