@extends('admin.includes.app')

@section('title')
    Natalpro | Admin | Settings
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">Settings</h3>
            </div>
        </div>
        
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h3> Update Settings </h3> <hr/>

                    <form class="form-horizontal" id="settings-form" action="#" method="post" onsubmit="return false">
                        {{csrf_field()}}
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label> Vaccination Price </label>
                                <input class="form-control" type="text" name="vaccination_amount" required="" onkeypress="return isCharNumber(event)" value="{{$settings->vaccination_amount}}"/> </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label> Kit Price </label>
                                <input class="form-control" type="text" name="kit_amount" required="" onkeypress="return isCharNumber(event)" value="{{$settings->kit_amount}}"/> </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label> Vaccination reminder welcome message </label> <br/>
                                <small> (<i> Ensure that this is not more than a page in order to conserve SMS units </i>)</small>
                                <textarea name="welcome_message" id="sample_english_message" class="form-control" rows="5">{{$settings->welcome_message}}</textarea>
                                <small id="count_pages"></small>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-info" id="settings-btn" onclick="return ajaxFormRequest('#settings-btn','#settings-form','/admin/settings','POST','#settings-status','Save changes','no')"><i class="fa fa-check"></i> Save changes </button> <br/>
                                <div id='settings-status' align='center'></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('admin.footer')
    </div>
</div>
@endsection
