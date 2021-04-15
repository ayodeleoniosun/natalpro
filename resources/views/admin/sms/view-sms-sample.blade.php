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
?>

@php($the_interval = Misc::selectedVacIntervals($vac_interval))

<script type="text/javascript">
    $(document).ready(function() {
        $('#viewVacSampleFormModal{{$vac_interval}}').modal('show');
    });
</script>

<div class="modal fade" id="viewVacSampleFormModal{{$vac_interval}}" tabindex="-1" role="dialog" aria-labelledby="vaccinationSampleFormModalLabel1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{$the_interval}} vaccination SMS </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                    
                @foreach($the_sample as $sample)

                    <div class="form-group">
                        <label>Message in {{$sample->language}} language</label>
                        <br/>
                        <small style="font-size:14px;white-space: initial;"> {!! html_entity_decode(ucfirst(nl2br($sample->sms))) !!} </small>
                    </div>

                @endforeach

                <div class="modal-footer" style="border:0px">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                
            </div>    
        </div>
    </div>
</div>
