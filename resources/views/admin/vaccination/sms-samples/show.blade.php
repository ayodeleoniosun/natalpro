<script type="text/javascript">
    $(document).ready(function() {
        $('#sampleModal{{ $identifier }}').modal('show');
    });
</script>

<div class="modal fade" id="sampleModal{{ $identifier }}" tabindex="-1" role="dialog" aria-labelledby="sampleModalLabel1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $interval }} Vaccination SMS </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                @foreach($samples as $sample)
                    <div class="form-group">
                        <label class="text-info">Message in {{ ucfirst($sample->language) }} Language</label>
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
