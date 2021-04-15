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
    Natalpro | All Nursing Mothers
@endsection

@section('content')
    
    <div class="page-wrapper">

        @php($current_url = \Request::url())

        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">Nursing Mothers <span class="badge badge-info">{{$count_nursing_mothers}} </span></h3>
            </div>
        </div>
        
        <div class="container-fluid">

            <div class="card">
                <div class="card-body">

                    @if($count_nursing_mothers == 0) 
                        <div class="container">
                            <div class="alert alert-danger"> No nursing mother yet </div>
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
                                
                                    @foreach($nursing_mothers as $nursing_mother)

                                        @php($nursing_mother_fullname = Query::getFullname('users', $nursing_mother->id))

                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td><a href="{{$current_url}}/profile/{{$nursing_mother->id}}" class="text-info">{{$nursing_mother_fullname}}</a></td>
                                            <td><a href="mailto:{{$nursing_mother->email}}">{{$nursing_mother->email}}</a></td>
                                            <td><a href="tel:{{$nursing_mother->phone}}">{{$nursing_mother->phone}}</a></td>
                                            <td>
                                                {!! Query::getValue('local_govts','id', $nursing_mother->local_govt,'name') !!} , {!! Query::getValue('states','id', $nursing_mother->state,'name')  !!}
                                            </td>
                                            <td>
                                                @if($nursing_mother->activity == "offline")  
                                                    <p style='color:brown'>    
                                                        {{ucfirst($nursing_mother->activity)}}
                                                        <br/>
                                                        <small> Last seen on {!! Dates::convertDate($nursing_mother->last_seen_on, "three") !!} </small>
                                                    </p>
                                                @elseif($nursing_mother->activity == "online")  
                                                    <p class='text-primary'>    
                                                        {{ucfirst($nursing_mother->activity)}}
                                                    </p>
                                                @endif                                                
                                            </td>
                                            <td>
                                                <a href="{{$current_url}}/delete/{{$nursing_mother->id}}" onclick="return confirm('Delete nursing_mother?')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>

                                    @endforeach

                                </tbody>
                            </table>

                        </div>
                                                        
                        <div style="clear:both"></div>
                        <br/>   
                        <div class="pull-right"> {{$nursing_mothers->links("pagination::bootstrap-4")}} </div>
                    
                    @endif
                </div>
            </div>
        </div>
        
        @include('admin.footer')
    </div>
</div>
    
@endsection
