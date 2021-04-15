<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use DB;
use App\MyLib\Misc;
?>

<form class="form-horizontal" id="rate_nurse_form" method="POST" onsubmit="return false">
    {{csrf_field()}}
    <input type="hidden" name="the_request" value="{{$req_id}}"/>

    <div class="col-md-12">
        <label> Rating </label> <br/>
        <input name="rating" type="radio" id="rating1" value="1"/>
        <label for="rating1">1</label> &nbsp; &nbsp;
        <input name="rating" type="radio" id="rating2" value="2"/>
        <label for="rating2">2</label> &nbsp; &nbsp;
        <input name="rating" type="radio" id="rating3" value="3"/>
        <label for="rating3">3</label> &nbsp; &nbsp;
        <input name="rating" type="radio" id="rating4" value="4"/>
        <label for="rating4">4</label> &nbsp; &nbsp;
        <input name="rating" type="radio" id="rating5" value="5"/>
        <label for="rating5">5</label> &nbsp; &nbsp;
    </div> <br/>

    <div class="col-md-12">
        <label> Feedback </label>
        <textarea name="feedback" class="form-control" rows="5" placeholder="Max. of 200 characters" maxlength="200"></textarea>
    </div>

    <div class="modal-footer" style="border:0px">
        <div id="rate_nurse_status"></div>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="rate_nurse_btn" onclick="return ajaxFormRequest('#rate_nurse_btn','#rate_nurse_form','/portal/pregnant-nursing-women/rate-the-nurse','POST','#rate_nurse_status','Submit','no')" class="btn btn-info"><i class="fa fa-check"></i> Submit </button>
    </div>
</form>