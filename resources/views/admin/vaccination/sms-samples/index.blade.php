@extends('admin.includes.app')

@section('title')
    Natalpro | All Vaccination Reminder Sms Samples
@endsection

@section('content') 
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">Vaccination Reminder Sms Samples </h3>
            </div>
        </div>
        
        <div class="container-fluid">
           <!-- <h2 class="add-ct-btn pull-right"><button type="button" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark" data-toggle="modal" data-target="#vaccinationSampleFormModal" data-whatever="@mdo"><i class="mdi mdi-plus"></i> Add new vaccination sms sample</button></h2> -->

            <div style="clear:both;"></div>
            <br/>
            
            <div class="modal fade" id="vaccinationSampleFormModal" tabindex="-1" role="dialog" aria-labelledby="vaccinationSampleFormModalLabel1">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Vaccination SMS Sample Form</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" id="sms_sample_form" method="POST" onsubmit="return false">
                                {{csrf_field()}}

                                <div class="form-group">
                                    <label for="recipient-name" class="control-label">Select Vaccination Interval</label>
                                    <select name="interval" class="form-control">
                                        @foreach($intervals as $key => $interval) 
                                            <option value="{{ $key }}"> {{ $interval }} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="recipient-name" class="control-label">Message in English Language</label>
                                    <textarea name="sms_english" id="sample_english_message" class="form-control" rows="5"></textarea>
                                    <small id="count_pages"></small>
                                </div>
                                
                                <button type="button" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark" id="translate_btn" onclick="return translateThis('#translate_btn', '#sms_sample_btn', '#sample_english_message', '#translate-status')"><i class="fa fa-exchange"></i> Translate</button>
                                <div id="translate-status"></div>

                                <div id="translate_div" style="display:none">
                                    <br/>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Message in Yoruba Language</label>
                                        <textarea name="sms_yoruba" id="sms_yoruba" class="form-control" rows="5"></textarea>
                                        <small id="count_yoruba_pages"></small>
                                    </div>

                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Message in Igbo Language</label>
                                        <textarea name="sms_igbo" id="sms_igbo" class="form-control" rows="5"></textarea>
                                        <small id="count_igbo_pages"></small>
                                    </div>

                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Message in Hausa Language</label>
                                        <textarea name="sms_hausa" id="sms_hausa" class="form-control" rows="5"></textarea>
                                        <small id="count_hausa_pages"></small>
                                    </div>

                                </div>

                                <div class="modal-footer" style="border:0px">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" id="sms_sample_btn" style="display:none" onclick="return ajaxFormRequest('#sms_sample_btn','#sms_sample_form','/admin/sms-sample','POST','#sms_sample_status','Add','no')" class="btn btn-info">Add </button>
                                </div>
                                <div style="clear:both"></div>
                                <br/>
                                <div id="sms_sample_status" align="center"></div>
                            </form>
                        </div>    
                    </div>
                </div>
            </div>
        <div class="card">
            
            <div class="card-body">

            @if($samples->count() == 0) 
                <div class="alert alert-danger" style="margin:0 auto"> No vaccination reminder sms samples yet </div>
            @else
                <div class="table-responsive m-t-40">
                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Interval</th>
                                <th>SMS</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach($samples as $sample)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sample->vaccination_interval }}</td>
                                    <td>
                                        <button type="button" onclick="return ajaxLoadingRequest('/admin/vaccination/sms-sample/{{ $sample->interval }}', '#view-sample-status{{ $sample->interval }}', 'GET')" class="btn btn-sm btn-primary"> View </button>
                                        <div id="view-sample-status{{ $sample->interval }}"></div>
                                    </td>
                                    <!-- <td>
                                        <button class="btn btn-sm btn-info"><i class="fa fa-pencil"></i></button> &nbsp; &nbsp;
                                        <a href="#" onclick="return confirm('Delete Sms Sample?')" class="text-danger"><i class="fa fa-trash"></i></a>
                                    </td> -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            </div>
        </div>
        @include('admin.includes.footer')
    </div>
</div>
    
@endsection