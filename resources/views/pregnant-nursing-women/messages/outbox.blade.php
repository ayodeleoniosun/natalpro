<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Users;
use App\InboxResponses;
use App\MyLib\Dates;
use App\MyLib\Misc;
use App\MyLib\Query;
use DB;
use Session;
?>

@extends('pregnant-nursing-women.app')

@section('title')
    Natalpro | Pregnant and Nursing Women | My Outbox
@endsection

@section('content')

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">My Outbox</h3>
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

                <h2 class="add-ct-btn pull-left"><a href="{{ route('PregNursingMessages') }}" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark"><i class="mdi mdi-message-plus"></i> Inbox</a></h2>

                <h2 class="add-ct-btn pull-right"><button type="button" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark" data-toggle="modal" data-target="#sendMessageFormModal" data-whatever="@mdo"><i class="mdi mdi-message-plus"></i> Send a new message to admin</button></h2>

            <div style="clear:both;"></div>
            <br/>
                    
            <div class="card">
                <div class="card-body">

                    <div class="">

                        <div class="modal fade" id="sendMessageFormModal" tabindex="-1" role="dialog" aria-labelledby="sendMessageFormModalLabel1">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="addDeptAdminModalLabel1">Send a new message</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-horizontal" id="compose-message-form" method="POST" onsubmit="return false">
                                            {{csrf_field()}}
                                            <div class="form-group">
                                                <label for="recipient-name" class="control-label">Subject</label>
                                                <input type="text" class="form-control" name="subject"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="control-label">Message</label>
                                                <textarea name="message" class="form-control" rows="7" required></textarea>
                                            </div>
                                            
                                            <div class="modal-footer" style="border:0px">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="button" id="compose-message-btn" onclick="return ajaxFormRequest('#compose-message-btn','#compose-message-form','/portal/pregnant-nursing-women/send-message','POST','#compose-message-status','Send','no')" class="btn btn-info">Send </button>
                                            </div>
                                            <div style="clear:both"></div>
                                            <br/>
                                            <div id="compose-message-status" align="center"></div>
                                            
                                        </form>
                                    </div>    
                                </div>
                            </div>
                        </div>
                                
                        @if(count($outbox) > 0)

                            @php($counter = 0)

                            <div class="table-responsive m-t-40">
                                <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                            <th>Sent on</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($outbox as $key=>$message) 

                                            @php($counter+=1)

                                            @php($sent_on = Dates::chatTimeAgo(strtotime($message->created_at), "three"))

                                            @php($encode_message = Misc::encoder($message->id))

                                            <tr>
                                                <td> {{$counter}} </td>
                                                <td><a href="/portal/pregnant-nursing-women/messages/view/{{$encode_message}}">{{ucfirst(substr($message->subject,0,40))}} ... </a></td>
                                                <td class="max-texts"> <a href="/portal/pregnant-nursing-women/messages/view/{{$encode_message}}"> {{ucfirst(substr($message->message,0,60))}} </a></td>
                                                <td><small> {{$sent_on}} </small></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="pull-right"> {{$outbox->links()}} </div>

                        @endif
                            
                     <br/>
                </div>
            </div>
        </div>

        @include('pregnant-nursing-women.footer')
    </div>
</div>
    
@endsection
