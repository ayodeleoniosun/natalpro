<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Users;
use App\MyLib\Misc;
use App\MyLib\Query;
use App\MyLib\Dates;
use DB;
use Session;
?>

@extends('admin.app')

@section('title')
    Natalpro | All Payments
@endsection

@section('content')
    
    @php($current_url = \Request::url())

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">Payments  <span class="badge badge-info">{{$count_payments}} </span></h3>
            </div>
        </div>
        
        <div class="container-fluid">

            <div class="card">
                <div class="card-body">
                
                <div class="row" style="margin:10px">
                    @if($count_payments == 0) 
                        <div class="container">
                            <div class="alert alert-danger"> No payment yet </div>
                        </div>
                    @else

                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Payment ID </th>
                                        <th>Payment type </th>
                                        <th>User</th>
                                        <th>Amount (&#8358;)</th>
                                        <th>Paid on</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                
                                    @foreach($payments as $payment)

                                        @php($fullname = Query::getFullname('users', $payment->users_id))
                                        
                                        @php($user_type = Query::getValue('users', 'id', $payment->users_id,'user_type'))

                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$payment->payment_req_id}}</td>
                                            <td>{{ucfirst($payment->payment_type)}}</td>
                                            <td>
                                                @if($user_type == "pregnant-woman") 
                                                    <a href="/portal/controlling-room-admin/pregnant-women/profile/{{$payment->users_id}}" class="text-info">{{$fullname}}</a>
                                                @elseif($user_type == "nursing-mothers") 
                                                    <a href="/portal/controlling-room-admin/nursing-mothers/profile/{{$payment->users_id}}" class="text-info">{{$fullname}}</a>
                                                @else 
                                                    <a href="/portal/controlling-room-admin/natal-nurses/profile/{{$payment->users_id}}" class="text-info">{{$fullname}}</a>
                                                @endif
                                            </td>
                                            <td>{{number_format($payment->amount,2)}}</a></td>
                                            <td>{!! Dates::formatDate($payment->created_at) !!} </td>
                                        </tr>

                                    @endforeach

                                </tbody>
                            </table>

                        </div>

                        <div style="clear:both"></div>
                        <br/>
                        <div class="pull-right"> {{$payments->links("pagination::bootstrap-4")}} </div>

                    @endif
                </div>
            </div>
        </div>

        @include('admin.footer')
    </div>
</div>
    
@endsection
