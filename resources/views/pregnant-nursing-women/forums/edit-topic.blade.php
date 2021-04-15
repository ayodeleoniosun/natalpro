<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\MyLib\Misc;
use DB;
?>

@extends('pregnant-nursing-women.app')

@section('title')
    Natalpro | Edit Topic
@endsection

@section('content')

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Edit Topic</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Edit Topic</li>
                </ol>
            </div>
        </div>
        
        <div class="container-fluid">

        <h2 class="add-ct-btn pull-left"><button onclick="return window.history.back()" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark"><i class="fa fa-arrow-circle-left"></i> Back</button></h2>
        <div style="clear:both;"></div>
        <br/>
            
        <div class="card">
            <div class="card-body">

                <div id="topic-form">

                    <form class="form-horizontal" id="update_topic_form" method="POST" onsubmit="return false" enctype="multipart/form-data">
                        {{csrf_field()}}

                        <input type="hidden" name="forum" value="{!! Misc::encoder($the_forum->id) !!}"/>
                    
                        <div class="form-group">
                            <label> Title </label> <br/>
                            <input type="text" class="form-control" name="title" value="{{$the_forum->title}}"/>
                        </div>

                        <div class="form-group">
                            <label> Content </label> <br/>
                            <textarea name="content" class="form-control" rows="7">{{$the_forum->content}}</textarea>
                        </div>

                        <div class="modal-footer" style="border:0px">
                            <button type="button" id="update_topic_btn" onclick="return ajaxFormRequest('#update_topic_btn','#update_topic_form','/portal/pregnant-nursing-women/update-topic','POST','#update_topic_status','Save changes','yes')" class="btn btn-info">Save changes </button>
                        </div>
                        <div style="clear:both"></div>
                        
                        <div id="update_topic_status" align="center"></div>
                        
                    </form>

                </div>
            </div>
        </div>
                
        </div>
    </div>    
@endsection
