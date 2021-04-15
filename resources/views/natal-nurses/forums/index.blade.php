<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use DB;
use App\Forums;
use App\MyLib\Dates;
use App\MyLib\Misc;
use Session;
?>

@extends('natal-nurses.pusher-app')

@section('title')
    Natalpro | Forum
@endsection

@section('content')
    
    @php($current_url = \Request::url())

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">Forum</h3>
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
                    
                    @if(count($forums) == 0) 
                        <div class="alert alert-danger" style="margin:0 auto"> No post yet </div>
                    @else
                        <ul class="search-listing">
                            
                            @foreach($forums as $forum)
                                
                                @php($comments = Forums::find($forum->id)->forumcomments)
                                @php($views = Forums::find($forum->id)->forumviews)

                                <li>
                                    <h3 class="text-info"><a href="{{$current_url}}/view/{{$forum->slug}}" style="text-decoration:none">
                                        @if(strlen($forum->title) > 90)
                                            {{ ucfirst(substr($forum->content,0,90)) }} ...
                                        @else 
                                            {{ ucfirst($forum->title) }}
                                        @endif
                                    </a></h3>
                                    
                                    <div>
                                        <small style="font-size:12px"> <i class="fa fa-calendar"></i> {!! Dates::chatTimeAgo(strtotime($forum->created_at), "three") !!} </small> &nbsp; &nbsp;
                                        <small style="font-size:12px"> <i class="fa fa-comments"></i> {{count($comments)}} comments </small>  &nbsp; &nbsp;
                                        <small style="font-size:12px"> <i class="fa fa-comments"></i> {{count($views)}} views </small>
                                    </div>
                                    <br/>

                                    <p style='font-size:14px'>

                                        @if(strlen($forum->content) > 1000)
                                            {{ ucfirst(substr($forum->content,0,500)) }} ... &nbsp; <a href="{{$current_url}}/view/{{$forum->slug}}" style="text-decoration:none" class="text-info">Read more &raquo;</a>
                                        @else 
                                            {!! html_entity_decode(ucfirst(nl2br($forum->content))) !!}
                                        @endif 
                                    </p>
                                </li>
                            @endforeach
                        
                        </ul>
                    @endif

                </div>
            </div>
            <div style="clear:both"></div>
                
        </div>
    </div>    
@endsection
