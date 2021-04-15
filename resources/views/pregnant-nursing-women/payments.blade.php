<?php

namespace App\Http\Controllers;
use Illuminate\Http\payment;
use Illuminate\Http\RedirectResponse;
use App\Users;
use App\MyLib\Dates;
use App\MyLib\Misc;
use App\MyLib\Query;
use DB;
use Session;
?>

@extends('pregnant-nursing-women.app')

@section('title')
    Natalpro | Pregnant and Nursing Women | Payments
@endsection

@section('content')
    
    @php($fullname = Query::getFullname('users',$user_id))

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-7 align-self-center">
                <h3 class="text-themecolor">Payments <span class="badge badge-info">{{$count_payments}} </span></h3>
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

                    <div class="">

                    @if($count_payments == 0) 
                        <div class="alert alert-danger" style="margin:0 auto"> No payment yet </div>
                    @else

                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Payment type</th>
                                        <th>Payment ID</th>
                                        <th>Amount (&#8358;)</th>
                                        <th>Paid on</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach($payments as $key=>$payment)

                                        <tr>
                                            <td>{{$key+=1}}</td>
                                            <td>{{ucfirst($payment->payment_type)}}</td>
                                            <td>{{$payment->payment_req_id}}</td>
                                            <td> {{number_format($payment->amount, 2)}}</td>
                                            <td> {!! Dates::formatDate($payment->created_at) !!} </td>     
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <br/>
                        <div class="pull-right"> {{$payments->links()}} </div> <br/>
                    @endif
                     <br/>
                </div>
            </div>
        </div>

        @include('pregnant-nursing-women.footer')
    </div>
</div>
    
@endsection
