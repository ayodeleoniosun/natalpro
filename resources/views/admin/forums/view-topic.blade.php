<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\MyLib\Misc;
use App\Forums;
use DB;
?>

@extends('admin.app')

@section('title')
    Natalpro | {{$the_forum->title}}
@endsection

@section('content')
    
    @php($comments = Forums::find($the_forum->id)->forumcomments)
    @php($views = Forums::find($the_forum->id)->forumviews)

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12">
                <h3 class="text-themecolor">{{$the_forum->title}}</h3>
            </div>
        </div>
        
        <div class="container-fluid">

        <h2 class="add-ct-btn pull-left"><button onclick="return window.history.back()" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark"><i class="fa fa-arrow-circle-left"></i> Back</button></h2>
        <div style="clear:both;"></div>
        <br/>
            
        <div class="card">
            <div class="card-body">
                
                <small style="font-size:14px"> {!! html_entity_decode(ucfirst(nl2br($the_forum->content))) !!} </small>

                <hr/>

                <h3> <i class="fa fa-comments"></i> <span id="count_comments"> {{ count($comments) }} </span> comments </h3>

                @if(count($comments) == 0)
                    <div class="alert alert-danger"> No comments yet </div>
                @else
                    
                    <script type="text/javascript">
                        $(document).ready(function() {
                            var url = "/portal/controlling-room-admin/forums/comments/{!!Misc::encoder($the_forum->id)!!}"
                            ajaxLoadingRequest(url, '#all_comments', '', 'GET');
                        });
                    </script>
                    <div id="all_comments"></div>
                
                @endif

                <br/>
                <form class="form-horizontal" id="comment_form" method="POST" onsubmit="return false">
                    {{csrf_field()}}

                    <input type="hidden" name="forum" value="{!! Misc::encoder($the_forum->id) !!}"/>
                
                    <div class="form-group">
                        <textarea name="comment" id="comment" class="form-control" rows="7" placeholder="Type your comment below"></textarea>
                    </div>

                    <button type="button" id="comment_btn" onclick="return ajaxFormRequest('#comment_btn','#comment_form','/portal/controlling-room-admin/comment','POST','#comment_status','Comment','no')" class="btn btn-info pull-right"> Comment</button>
                    <div style="clear:both"></div>
                    
                    <div id="comment_status" align="center"></div>
                    
                </form>
            </div>
        </div>
                
        </div>
    </div>    
@endsection
