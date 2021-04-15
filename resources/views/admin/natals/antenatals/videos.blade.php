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


@if($count_antenatals == 0) 
    <br/><p class="text-danger" style="margin:0 auto"> No video yet </p>
@else
    
    <div class="container-fluid">
        <div class="row">

            @foreach($antenatals as $video)

                @php($category = Categories::where('id', $video->category_id)->value('name'))
            
                <h3 class="natal-heading row" align="center"> {{ucfirst(strtolower($category))}} </h3>
                
                @php($antenatal_videos = AntePostNatal::where('section_type','antenatal')->where('file_type','video')->where('category_id',$video->category_id)->paginate(15))
                
                @foreach($antenatal_videos as $each_video)
                    
                    <div class="col-sm-6 col-xs-12 col-md-6">
                        <div class="modal fade" id="editVideoModal{{$each_video->id}}" tabindex="-1" role="dialog" aria-labelledby="editVideoModalLabel{{$each_video->id}}" data-backdrop="false">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="editVideoModalLabel{{$each_video->id}}">Edit video details</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-horizontal" id="update_antenatal_form{{$each_video->id}}" method="POST" onsubmit="return false">
                                            {{csrf_field()}}
                                            
                                            <div class="form-group">
                                                <label> Select category</label>
                                                {!! Misc::selectedAnteNatalCategory($each_video->category_id) !!}
                                            </div>

                                            <div class="form-group">
                                                <label> Title (Max. of 200 characters)</label>
                                                <input type="text" name="title" class="form-control" value="{{$each_video->title}}" maxlength="200"/>
                                            </div>

                                            <div class="form-group" id="video_div">
                                                <label> Youtube video embed link </label><br/>
                                                
                                                <textarea name="video" rows="3" class="form-control">{{$each_video->path}} </textarea>

                                            </div>
                                            
                                            <div class="modal-footer" style="border:0px">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" id="update_antenatal_btn{{$each_video->id}}" onclick="return ajaxFormRequest('#update_antenatal_btn{{$each_video->id}}','#update_antenatal_form{{$each_video->id}}','/portal/controlling-room-admin/update-antenatal/video/{{$each_video->id}}','POST','#update_antenatal_status{{$each_video->id}}','Save changes','no')" class="btn btn-info">Save changes </button>
                                            </div>
                                            <div style="clear:both"></div>
                                            <br/>
                                            <div id="update_antenatal_status{{$each_video->id}}" align="center"></div>
                                            
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
                            <a href="/portal/controlling-room-admin/antenatals/delete/{{$each_video->id}}" class="text-danger" onclick="return confirm('Delete video?')">Delete</a>
                        </div> 
                        <hr/>
                    </div>
                    
                @endforeach


            @endforeach
            <br/><br/>
            <div style="clear:both"></div>
            
            <div class="container" align="center"> {{$antenatals->links()}} </div>
           
        </div>
    </div>
@endif