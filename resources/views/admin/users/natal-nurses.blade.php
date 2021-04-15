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
    Natalpro | All Healthcare Professionals
@endsection

@section('content')
    
    @php($current_url = \Request::url())

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">Healthcare Professionals <span class="badge badge-info">{{$count_nurses}} </span></h3>
            </div>
        </div>
        
        <div class="container-fluid">

            <div class="card">
                <div class="card-body">
                
                <div class="row" style="margin:10px">
                    @if($count_nurses == 0) 
                        <div class="container">
                            <div class="alert alert-danger"> No healthcare professionals yet </div>
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
                                
                                    @foreach($nurses as $nurse)

                                        @php($nurse_fullname = Query::getFullname('users', $nurse->id))

                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td><a href="{{$current_url}}/profile/{{$nurse->id}}" class="text-info">{{$nurse_fullname}}</a></td>
                                            <td><a href="mailto:{{$nurse->email}}">{{$nurse->email}}</a></td>
                                            <td><a href="tel:{{$nurse->phone}}">{{$nurse->phone}}</a></td>
                                            <td>
                                                {!! Query::getValue('local_govts','id', $nurse->local_govt,'name') !!} , {!! Query::getValue('states','id', $nurse->state,'name')  !!}
                                            </td>
                                            <td>
                                                @if($nurse->activity == "offline")  
                                                    <p style='color:brown'>    
                                                        {{ucfirst($nurse->activity)}}
                                                        <br/>
                                                        <small> Last seen on {!! Dates::convertDate($nurse->last_seen_on, "three") !!} </small>
                                                    </p>
                                                @elseif($nurse->activity == "online")  
                                                    <p class='text-primary'>    
                                                        {{ucfirst($nurse->activity)}}
                                                    </p>
                                                @endif                                                
                                            </td>
                                            <td>
                                                <a href="{{$current_url}}/delete/{{$nurse->id}}" onclick="return confirm('Delete nurse?')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>

                                    @endforeach

                                </tbody>
                            </table>

                        </div>

                        <div style="clear:both"></div>
                        <br/>
                        <div class="pull-right"> {{$nurses->links("pagination::bootstrap-4")}} </div>

                    @endif
                </div>
            </div>
        </div>

        @include('admin.footer')
    </div>
</div>
    
@endsection
