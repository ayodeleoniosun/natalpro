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
    Natalpro | Admin | Kit Orders
@endsection

@section('content')

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">Kit Orders <span class="badge badge-info">{{$count_kit_orders}} </span></h3>
            </div>
        </div>
        
        <div class="container-fluid">
            
            
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

            <div class="card">
                <div class="card-body">

                    @if($count_kit_orders == 0) 
                        <div class="alert alert-danger" style="margin:0 auto"> No order yet.</div>
                    @else

                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Order ID</th>
                                        <th>User</th>
                                        <th>Fullname</th>
                                        <th>Phone</th>
                                        <th>Location</th>
                                        <th>Amount (&#8358;) </th>
                                        <th>Ordered on</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach($kit_orders as $key=>$order)

                                        @php($user_fullname = Query::getFullname('users', $order->users_id))

                                        @php($user_type = Query::getValue('users', 'id', $order->users_id,'user_type'))

                                        <tr>
                                            <td>{{$key+=1}}</td>
                                            <td>{{$order->req_id}}</td>
                                            <td>
                                                @if($user_type == "pregnant-woman") 
                                                    <a href="/portal/controlling-room-admin/pregnant-women/profile/{{$order->users_id}}" class="text-info">{{$user_fullname}}</a>
                                                @elseif($user_type == "nursing-mothers") 
                                                    <a href="/portal/controlling-room-admin/nursing-mothers/profile/{{$order->users_id}}" class="text-info">{{$user_fullname}}</a>
                                                @else 
                                                    <a href="/portal/controlling-room-admin/natal-nurses/profile/{{$order->users_id}}" class="text-info">{{$user_fullname}}</a>
                                                @endif
                                            </td>
                                            <td>{{ucwords($order->fullname)}}</td>
                                            <td><a href="tel:{{$order->phone}}">{{$order->phone}}</a></td>
                                            <td>{{$order->location}}</td>
                                            <td>{{number_format($order->amount,2)}}</td>
                                            <td>{!! Dates::formatDate($order->created_at, "three") !!}</td>
                                            <td>
                                                @if($order->status == "pending")  
                                                    <p style='color:brown'>    
                                                        {{ucfirst($order->status)}}
                                                    </p>
                                                @elseif($order->status == "active")  
                                                    <p class='text-primary'>    
                                                        {{ucfirst($order->status)}}
                                                    </p>
                                                @elseif($order->status == "declined")  
                                                    <p class='text-danger'>    
                                                        {{ucfirst($order->status)}}
                                                    </p>
                                                @endif                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <br/>
                        <div class="pull-right"> {{$kit_orders->links()}} </div>
                        <br/>
                    @endif
                     <br/>
                </div>
            </div>
        </div>

        @include('admin.footer')
    </div>
</div>
    
@endsection
