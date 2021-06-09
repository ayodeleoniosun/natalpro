@extends('user.includes.app')

@section('title')
    Natalpro | Vaccination Reminder
@endsection

@section('content') 
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">Vaccination Reminder Cycles for #{{ $vaccination->transaction_id }} </h3>
            </div>
        </div>
        
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h2 class="add-ct-btn pull-left">
                        <button onclick="return window.history.back()" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark">
                        <i class="fa fa-arrow-circle-left"></i> Back</button>
                    </h2>
                    
                    @if(!$vaccination) 
                        <div class="alert alert-danger" style="margin:0 auto"> Vaccination request not found </div>
                    @else
                        <div class="table-responsive">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Interval</th>
                                        <th>Vaccination Date</th>
                                        <th>Week Reminder Date</th>
                                        <th>Day Reminder Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach($vaccination->cycles as $key => $cycle)
                                        <tr>
                                            <td>{{ $key += 1 }}</td>
                                            <td>{{ $cycle->interval }}</td>
                                            <td>{{ $cycle->vaccination_date }}</td>
                                            <td>{{ $cycle->week_before }}</td>
                                            <td>{{ $cycle->day_before }}</td>
                                            <td><span class="{{ $cycle->active_status['color'] }}"> {{ $cycle->active_status['label'] }} </span> </td>
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
