<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use DB;
use App\MyLib\Misc;
?>


<script type="text/javascript">
$(document).ready(function() {
    $('#viewFeedbackModal{{$req_id}}').modal('show');
});
</script>

<div class="modal fade" id="viewFeedbackModal{{$req_id}}" tabindex="-1" role="dialog" aria-labelledby="viewFeedbackModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Feedback on chat {{str_replace("=", "",$request_id)}} </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                Rating  &nbsp; -  &nbsp; {{$rating}} / 5 &nbsp; {!! html_entity_decode($rating_status) !!}
                <hr/>
                Feedback <br/>
                    <p style='margin-left:20px'>{!! html_entity_decode(nl2br($feedback)) !!}</p>
                <div class="modal-footer" style="border:0px">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>    
        </div>
    </div>
</div>    
