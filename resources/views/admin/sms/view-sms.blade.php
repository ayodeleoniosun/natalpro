<script type="text/javascript">
    $(document).ready(function() {
        $('#viewVacSmsModal{{$the_sms->id}}').modal('show');
    });
</script>

<div class="modal fade" id="viewVacSmsModal{{$the_sms->id}}" tabindex="-1" role="dialog" aria-labelledby="vaccinationSampleFormModalLabel1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Vaccination SMS </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <small style="font-size:14px;white-space: initial;"> {!! html_entity_decode(ucfirst(nl2br($the_sms->sms))) !!} </small> 
                <div class="modal-footer" style="border:0px">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                
            </div>    
        </div>
    </div>
</div>
