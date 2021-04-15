<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Users;
use App\MyLib\Dates;
use App\MyLib\Misc;
use App\MyLib\Query;
use DB;
use Session;
?>

@extends('admin.app')

@section('title')
    Natalpro | All Pregnant Women
@endsection

@section('content')
    
    <div class="page-wrapper">

        @php($current_url = \Request::url())

        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">Pregnant Women <span class="badge badge-info">{{$count_patients}} </span></h3>
            </div>
        </div>
        
        <div class="container-fluid">

            <div class="card">
                <div class="card-body">

                    @if($count_patients == 0) 
                        <div class="container">
                            <div class="alert alert-danger"> No pregnant woman yet </div>
                        </div>
                    @else

                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Fullname</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                
                                    @foreach($patients as $patient)

                                        @php($patient_fullname = Query::getFullname('users', $patient->id))

                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td><a href="{{$current_url}}/profile/{{$patient->id}}" class="text-info">{{$patient_fullname}}</a></td>
                                            <td><a href="mailto:{{$patient->email}}">{{$patient->email}}</a></td>
                                            <td><a href="tel:{{$patient->phone}}">{{$patient->phone}}</a></td>
                                            <td>
                                                {!! Query::getValue('local_govts','id', $patient->local_govt,'name') !!} , {!! Query::getValue('states','id', $patient->state,'name')  !!}
                                            </td>
                                            <td>
                                                @if($patient->activity == "offline")  
                                                    <p style='color:brown'>    
                                                        {{ucfirst($patient->activity)}}
                                                        <br/>
                                                        <small> Last seen on {!! Dates::convertDate($patient->last_seen_on, "three") !!} </small>
                                                    </p>
                                                @elseif($patient->activity == "online")  
                                                    <p class='text-primary'>    
                                                        {{ucfirst($patient->activity)}}
                                                    </p>
                                                @endif                                                
                                            </td>
                                            <td>
                                                <a href="{{$current_url}}/delete/{{$patient->id}}" onclick="return confirm('Delete patient?')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>

                                    @endforeach

                                </tbody>
                            </table>

                        </div>
                                                        
                        <div style="clear:both"></div>
                        <br/>   
                        <div class="pull-right"> {{$patients->links("pagination::bootstrap-4")}} </div>
                    
                    @endif
                </div>
            </div>
        </div>
        
        @include('admin.footer')
    </div>
</div>
    
@endsection
