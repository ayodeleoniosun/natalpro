<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use DB;
?>

@extends('pregnant-nursing-women.app')

@section('title')
    Natalpro | Create a New Topic
@endsection

@section('content')

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">Create a New Topic</h3>
            </div>
        </div>
        
        <div class="container-fluid">

        <h2 class="add-ct-btn pull-left"><button onclick="return window.history.back()" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark"><i class="fa fa-arrow-circle-left"></i> Back</button></h2>
        <div style="clear:both;"></div>
        <br/>
            
        <div class="card">
            <div class="card-body">

                <div id="rules_div">
                    
                    <h5> Please observe the following rules before you create a new topic: </h5>
                    <div class="alert alert-default">
                        <ul class="lists">
                            <li> Don't abuse, bully, deliberately insult/provoke, fight, or wish harm to any natalnurse members. </li>
                            <li> Posting of adverts or affiliate links is highly prohibited. </li>
                            <li> Don't create distracting posts with all words in capital letters. </li>
                            <li> Please search the forum before creating a new topic as your question might have been answered before. </li>
                            <li> Don't spam the forum by advertising or posting the same content many times. </li>
                            <li> Don't ask natalnurse members for contact details (email, phone, bbpin) or investments. </li>
                        </ul>
                    </div>

                    <br/>
                    <button onclick="return NextBtn('#rules_div','#topic-form')" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark pull-right"> Continue <i class="fa fa-arrow-circle-right"></i></button>

                </div>

                <div id="topic-form" style="display:none">

                    <form class="form-horizontal" id="topic_form" method="POST" onsubmit="return false" enctype="multipart/form-data">
                        {{csrf_field()}}

                        <div class="form-group">
                            <label> Title </label> <br/>
                            <input type="text" class="form-control" name="title"/>
                        </div>

                        <div class="form-group">
                            <label> Content </label> <br/>
                            <textarea name="content" class="form-control" rows="7"></textarea>
                        </div>

                        <div class="modal-footer" style="border:0px">
                            <button type="button" id="topic_btn" onclick="return ajaxFormRequest('#topic_btn','#topic_form','/portal/pregnant-nursing-women/submit-topic','POST','#topic_status','Create','yes')" class="btn btn-info">Create </button>
                        </div>
                        <div style="clear:both"></div>
                        
                        <div id="topic_status" align="center"></div>
                        
                    </form>

                </div>
            </div>
        </div>
                
        </div>
    </div>    
@endsection
