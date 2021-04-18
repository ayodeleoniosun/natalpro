<script type="text/javascript">
    $(document).ready(function() {
        $('#editSampleModal{{$vac_interval}}').modal('show');
        $("#translate_update_btn").click(function() {
            $("#update_sms_sample_btn").hide("fast");
            $(this).attr("disabled", "disabled");
            $(this).html("Please wait ...");

            const message = $("#update_sample_english_message").val();
            const data = "message="+message;
            const translate = ajaxLoadingRequest('/portal/controlling-room-admin/translate-vaccination', '#update-translate-status', data, 'POST');
        });
    });
</script>


<div class="modal fade" id="editSampleModal{{$vac_interval}}" tabindex="-1" role="dialog" aria-labelledby="vaccinationSampleFormModalLabel1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $modified_interval }} vaccination SMS sample form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="update_sms_sample_form" method="POST" onsubmit="return false">
                    {{csrf_field()}}
                    <input type="hidden" name="interval" value="{{ $interval }}"/>

                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Select vaccination interval</label> <br/>
                        {!! Misc::theSelectedVacIntervals($vac_interval) !!}
                    </div>

                    @foreach($samples as $sample)                        
                        <script type="text/javascript">
                            $("#sms_{{$sample->language}}_{{$vac_interval}}").on('keypress keyup keydown blur mouseleave', function(event) {    
                                if(event.keyCode == 13) {
                                    event.preventDefault();
                                }
                                getMessagePages(this, "#count_{{$sample->language}}_{{$vac_interval}}_pages");
                            });

                        </script>

                        @if($sample->language == "english")
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">Message in english language</label>
                                <br/>
                                <textarea name="sms_english" id="sms_english_{{$vac_interval}}" class="form-control" rows="5">{{$sample->sms}}</textarea>
                                <br/>
                                <small id="count_english_{{$vac_interval}}_pages"></small>
                            </div>

                            <button type="button" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark" id="update_translate_btn" onclick="return updateTranslate('#update_translate_btn', '#update_sms_sample_btn', '#sms_english_{{$vac_interval}}', '#update-translate-status', '{{$vac_interval}}')"><i class="fa fa-exchange"></i> Translate</button>
                            <div id="update-translate-status"></div>
                            <br/> <br/>
                        @else
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">Message in {{$sample->language}} language</label> <br/>
                                <textarea name="sms_{{$sample->language}}" id="sms_{{$sample->language}}_{{$vac_interval}}" class="form-control" rows="5">{{$sample->sms}}</textarea> <br/>
                                <small id="count_{{$sample->language}}_{{$vac_interval}}_pages"></small>
                            </div>
                        @endif

                    @endforeach

                    <div class="modal-footer" style="border:0px">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" id="update_sms_sample_btn" onclick="return ajaxFormRequest('#update_sms_sample_btn','#update_sms_sample_form','/portal/controlling-room-admin/vaccination-sms-sample-requests/operation/update','POST','#update_sms_sample_status','Save changes','no')" class="btn btn-info">Save changes </button>
                    </div>
                    <div style="clear:both"></div>
                    <br/>
                    <div id="update_sms_sample_status" align="center"></div>
                    
                </form>
            </div>    
        </div>
    </div>
</div>