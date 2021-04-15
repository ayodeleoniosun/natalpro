<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Users;
use App\MyLib\Dates;
use App\MyLib\Misc;
use App\MyLib\Query;
use DB;
use Session;
use URL;
?>

<script src="{{ URL::asset('js/natalnurse.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#assignNurseModal{{$req_id}}').modal('show');
    });
</script>

<div class="modal fade" id="assignNurseModal{{$req_id}}" tabindex="-1" role="dialog" aria-labelledby="assignNurseModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Assign Nurse to Request {{$request->req_id}} </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="assign-nurse-form" method="POST" onsubmit="return false">
                    {{csrf_field()}}
                    <input type="hidden" name="req_id" value="{!! Misc::encoder($req_id) !!}"/>
                    <div class="form-group">
                        <label> Select Nurse </label> <br/>
                        {!! Misc::getNurses() !!}
                    </div>

                    <div class="modal-footer" style="border:0px">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" id="assign-nurse-btn" onclick="return ajaxFormRequest('#assign-nurse-btn','#assign-nurse-form','/portal/controlling-room-admin/nurse-requests/operation/assign-nurse','POST','#assign-nurse-status','Assign','no')" class="btn btn-info">Assign </button>
                    </div>
                    <div style="clear:both"></div>
                    <br/>
                    <div id="assign-nurse-status" align="center"></div>
                    
                </form>
            </div>    
        </div>
    </div>
</div>    
