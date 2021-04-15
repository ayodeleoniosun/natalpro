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

@extends('admin.app')

@section('title')
    Natalpro | Postnatals
@endsection

@section('content')
    
    @php($current_url = \Request::url())

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">Postnatals  <span class="badge badge-info">{{$count_postnatals}} </span></h3>
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

            <h2 class="add-ct-btn pull-right"><button type="button" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark" data-toggle="modal" data-target="#postnatalFormModal" data-whatever="@mdo"><i class="mdi mdi-upload"></i> Upload new postnatal</button></h2>
                    
            <div style="clear:both;"></div>
            <br/>

            <div class="modal fade" id="postnatalFormModal" tabindex="-1" role="dialog" aria-labelledby="postnatalFormModalLabel1">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="addDeptAdminModalLabel1">Upload New Postnatal</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" id="postnatal_form" method="POST" onsubmit="return false" enctype="multipart/form-data">
                                {{csrf_field()}}
                                
                                <div class="form-group">
                                    <label for="recipient-name" class="control-label">Select upload type</label>
                                    {!! Misc::antePostNatalUploadTypes() !!}
                                </div>
                                
                                <div class="form-group" id="audio_div" style="display:none">
                                    <label> Select audio file</label> <br/>
                                    <input type="file" name="audio" accept=".mp3, .wav, .amr, .MP3, .WAV, .AMR"/>
                                </div>
                                
                                <div class="form-group" id="video_div" style="display:none">
                                    <label> Youtube video embed link </label><br/>
                                    <textarea name="video" rows="3" class="form-control"></textarea>
                                </div>
                                
                                <div class="form-group" id="others_div" style="display:none">
                                    <label> Select file (PDF,Doc, and Images) </label><br/>
                                    <input type="file" name="others" accept=".pdf,.docx,.doc,.jpg,.png,.JPEG,jpeg,PNG,JPG"/>
                                </div>
                                
                                <div class="form-group">
                                    <label> Select category</label>
                                    {!! Misc::getPostNatalCategories() !!}
                                </div>

                                <div class="form-group">
                                    <label> Title (Max. of 200 characters) (optional)</label>
                                    <input type="text" name="title" class="form-control" maxlength="200"/>
                                </div>

                                <!-- <div class="form-group">
                                    <label> Short description (Max. of 200 characters) (optional)</label>
                                    <textarea name="description" rows="5" class="form-control" maxlength="200"></textarea>
                                </div> -->

                                <div class="modal-footer" style="border:0px">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                     <button type="submit" id="postnatal_btn" onclick="return ajaxFormRequest('#postnatal_btn','#postnatal_form','/portal/controlling-room-admin/upload-postnatal','POST','#postnatal_status','Upload','yes')" class="btn btn-info">Upload </button>
                                </div>
                                <div style="clear:both"></div>
                                <br/>
                                <div id="postnatal_status" align="center"></div>
                                
                            </form>
                        </div>    
                    </div>
                </div>
            </div>
            

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
                            @if($count_postnatals == 0) 
                                <br/><p class="text-danger" style="margin:0 auto"> No video yet </p><br/>
                            @else
                                
                                <div class="container-fluid">
                                    <div class="row">

                                        @foreach($categories as $category)

                                            @php($postnatal_videos = AntePostNatal::where('section_type','postnatal')->where('file_type','video')->where('category_id',$category->id)->get())
                                            
                                            @php($count_postnatal_videos = AntePostNatal::where('section_type','postnatal')->where('file_type','video')->where('category_id',$category->id)->count())
                                            
                                            @if($count_postnatal_videos > 0)
                                                <h3 class="natal-heading row" align="center"> {{ucfirst(strtolower($category->name))}} </h3>
                                                
                                                @foreach($postnatal_videos as $each_video)
                                                    
                                                    <div class="col-sm-6 col-xs-12 col-md-6">
                                                        <div class="modal fade" id="editVideoModal{{$each_video->id}}" tabindex="-1" role="dialog" aria-labelledby="editVideoModalLabel{{$each_video->id}}">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" id="editVideoModalLabel{{$each_video->id}}">Edit video details</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form class="form-horizontal" id="update_postnatal_form{{$each_video->id}}" method="POST" onsubmit="return false">
                                                                            {{csrf_field()}}
                                                                            
                                                                            <div class="form-group" id="video_div">
                                                                                <label> Youtube video embed link </label><br/>
                                                                                
                                                                                <textarea name="video" rows="3" class="form-control">{{$each_video->path}} </textarea>

                                                                            </div>
                                                                            
                                                                            <div class="form-group">
                                                                                <label> Select category</label>
                                                                                {!! Misc::selectedPostNatalCategory($each_video->category_id) !!}
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label> Title (Max. of 200 characters)</label>
                                                                                <input type="text" name="title" class="form-control" value="{{$each_video->title}}" maxlength="200"/>
                                                                            </div>

                                                                            <div class="modal-footer" style="border:0px">
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                <button type="submit" id="update_postnatal_btn{{$each_video->id}}" onclick="return ajaxFormRequest('#update_postnatal_btn{{$each_video->id}}','#update_postnatal_form{{$each_video->id}}','/portal/controlling-room-admin/update-postnatal/video/{{$each_video->id}}','POST','#update_postnatal_status{{$each_video->id}}','Save changes','no')" class="btn btn-info">Save changes </button>
                                                                            </div>
                                                                            <div style="clear:both"></div>
                                                                            <br/>
                                                                            <div id="update_postnatal_status{{$each_video->id}}" align="center"></div>
                                                                            
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        
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
                                                        
                                                        <div class="container" align="center">
                                                            <a href="#" class="text-info" data-toggle="modal" data-target="#editVideoModal{{$each_video->id}}" data-whatever="@mdo">Edit</a> &nbsp; &nbsp; 
                                                            <a href="/portal/controlling-room-admin/postnatals/delete/{{$each_video->id}}" class="text-danger" onclick="return confirm('Delete video?')">Delete</a>
                                                        </div> 
                                                        <hr/>
                                                    </div>
                                                    
                                                @endforeach

                                            @endif

                                        @endforeach
                                    
                                    </div>
                                    <br/>
                                        
                                        <div class="container" align="center"> {{$categories->links()}} </div>
                                       
                                    </div>
                                </div>
                            @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.footer')
    </div>
</div>
    
@endsection