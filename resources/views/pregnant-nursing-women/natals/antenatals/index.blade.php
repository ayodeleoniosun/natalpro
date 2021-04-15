<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Users;
use App\Categories;
use App\AntePostNatal;
use App\MyLib\Misc;
use App\MyLib\Query;
use DB;
use Session;
?>

@extends('pregnant-nursing-women.app')

@section('title')
    Natalpro | Antenatals
@endsection

@section('content')
    
    @php($current_url = \Request::url())

    <div class="page-wrapper">
        
        @if($the_user->user_type == "pregnant-woman")
            
            <div class="row page-titles">
                <div class="col-md-12 align-self-center">
                    <h3 class="text-themecolor">Antenatals  <span class="badge badge-info">{{$count_antenatals}} </span></h3>
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

                <div style="clear:both;"></div>
                <br/>

                <div class="rowcol-md-12">
                    <div class="card">
                        
                        <div class="card-body p-b-0">
                        
                        <ul class="nav nav-tabs customtab" role="tablist">
                            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#" role="tab"><span>Videos</span></a> </li>
                            <!-- <li class="nav-item"> <a class="nav-link" href="{{$current_url}}/articles" role="tab"><span>Articles</span></a> </li> -->
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            
                            <div class="tab-pane active" id="videos" role="tabpanel">
                                @if($count_antenatals == 0) 
                                    <br/><p class="text-danger" style="margin:0 auto"> No video yet </p> <br/>
                                @else
                                    
                                    <div class="container-fluid">
                                        <div class="row">

                                            @foreach($categories as $category)

                                                @php($antenatal_videos = AntePostNatal::where('section_type','antenatal')->where('file_type','video')->where('category_id',$category->id)->get())
                                                
                                                @php($count_antenatal_videos = AntePostNatal::where('section_type','antenatal')->where('file_type','video')->where('category_id',$category->id)->count())
                                                
                                                @if($count_antenatal_videos > 0)
                                                    <h3 class="natal-heading row" align="center"> {{ucfirst(strtolower($category->name))}} </h3>
                                                    
                                                    @foreach($antenatal_videos as $each_video)
                                                        
                                                        <div class="col-sm-6 col-xs-12 col-md-6">
                                                            <br/>
                                                            {!! html_entity_decode($each_video->path) !!}
                                                            <br/>
                                                            <h4> 
                                                                @if($each_video->title == "")
                                                                    No title 
                                                                @else
                                                                    {{$each_video->title}}
                                                                @endif
                                                            </h4>
                                                            
                                                        </div>
                                                        
                                                    @endforeach

                                                @endif

                                            @endforeach
                                        </div>
                                        <br/><hr/>
                                        <br/>
                                            
                                            <div class="container" align="center"> {{$categories->links()}} </div>
                                           
                                        </div>
                                    </div>
                                @endif

                        </div>
                    </div>
                </div>
            </div>
        @else
            <br/><br/>
            <div class="container-fluid">
                <div class="alert alert-danger"> You are not authorized to see this page </div>
            </div>
        @endif
    </div>

    @include('pregnant-nursing-women.footer')
    
@endsection