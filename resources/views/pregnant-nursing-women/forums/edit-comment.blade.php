<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\ForumComments;
use App\MyLib\Dates;
use App\MyLib\Misc;
use App\MyLib\Query;
use DB;
use Session;
?>

<script type="text/javascript">
$(document).ready(function() {
    $('#editCommentModal{{$forum_comment->id}}').modal('show');
});
</script>

<div class="modal fade" id="editCommentModal{{$forum_comment->id}}" tabindex="-1" role="dialog" aria-labelledby="editCommentModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Comment </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="update-comment-form" method="POST" onsubmit="return false">
                    {{csrf_field()}}
                    <input type="hidden" name="comment_id" value="{!! Misc::encoder($forum_comment->id) !!}"/>
                    <div class="form-group">
                        <textarea name="comment" id="comment" class="form-control" rows="7">{{$forum_comment->comment}}</textarea>
                    </div>

                    <div class="modal-footer" style="border:0px">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" id="update-comment-btn" onclick="return ajaxFormRequest('#update-comment-btn','#update-comment-form','/portal/pregnant-nursing-women/forum-requests/operation/update-comment','POST','#update-comment-status','Save changes','no')" class="btn btn-info">Save changes </button>
                    </div>
                    <div style="clear:both"></div>
                    <div id="update-comment-status" align="center"></div>
                    
                </form>
            </div>    
        </div>
    </div>
</div>    
