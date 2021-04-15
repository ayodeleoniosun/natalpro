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

@extends('pregnant-nursing-women.app')

@section('title')
    Natalpro | Pregnant and Nursing Women | Kit Orders
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

                    <h2 class="add-ct-btn pull-right"><button type="button" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark" data-toggle="modal" data-target="#kitFormModal" data-whatever="@mdo"><i class="mdi mdi-medical-bag"></i> Order new kit</button></h2>
                <div style="clear:both;"></div>
                     <br/>
                    
            <div class="card">
                <div class="card-body">

                    <div class="">

                        <div class="modal fade" id="kitFormModal" tabindex="-1" role="dialog" aria-labelledby="kitFormModalLabel1">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="addDeptAdminModalLabel1">Kit Order Form</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-horizontal" id="kit_form" method="POST" onsubmit="return false">
                                            {{csrf_field()}}

                                            <div class="form-group">
                                                <label for="recipient-name" class="control-label">Fullname</label>
                                                <input type="text" class="form-control" name="fullname"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="control-label">Phone number </label>
                                                <input type="text" class="form-control" name="phone"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="control-label">Location</label>
                                                <textarea name="location" class="form-control" rows="5"></textarea>
                                            </div>

                                            <div class="modal-footer" style="border:0px">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="button" id="kit_btn" onclick="return ajaxFormRequest('#kit_btn','#kit_form','/portal/pregnant-nursing-women/order-kit','POST','#kit_status','Submit','no')" class="btn btn-info">Submit </button>
                                            </div>
                                            <div style="clear:both"></div>
                                            <br/>
                                            <div id="kit_status" align="center"></div>
                                            
                                        </form>
                                    </div>    
                                </div>
                            </div>
                        </div>
                        
                    @if($count_kit_orders == 0) 
                        <div class="alert alert-danger" style="margin:0 auto"> You haven't ordered any kit.</div>
                    @else

                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Request ID</th>
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
                                        <tr>
                                            <td>{{$key+=1}}</td>
                                            <td>{{$order->req_id}}</td>
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

        @include('pregnant-nursing-women.footer')
    </div>
</div>
    
@endsection
