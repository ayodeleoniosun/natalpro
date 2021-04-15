@extends('user.vaccination.template')

@section('title')
    Natalpro | Vaccination
@endsection

@section('content')
    <section id="wrapper" style="margin-top:-30px">
        <div class="login-register" style="background-image:url(/assets/images/background/login-register.jpg);">
            <div style="margin:auto">
                <div class="card-body">
                    <div align="center">
                        <a href="http://www.natalpro.org">
                            <img src="{{ URL::asset('assets/images/logo-icon.png')}}" alt="homepage" class="dark-logo" class="img-responsive img-thumbnail" style="width:100px"/>
                        </a>
                    </div>
                    <br/>

                    <div class="row" id="validation">
                        <div class="col-sm-6 col-sm-offset-3">
                            <div class="card wizard-content">
                                <div class="card-body">
                                    <h2 class="card-title" align="center">Register For Our Vaccination Reminder!</h2>

                                    <form class="form-horizontal form-material" id="vaccination_form" method="POST" onsubmit="return false">
                                        {{csrf_field()}}

                                        <div class="form-group">
                                            <label class="control-label">Firstname</label>
                                            <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}"/>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label">Lastname</label>
                                            <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}"/>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label">Language</label>
                                            <select name="language" class="form-control">
                                                @foreach ($languages as $language) 
                                                    <option value="{{ $language }}"> {{ ucfirst($language) }} </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Mother's name</label>
                                            <input type="text" class="form-control" name="mother" value="{{ old('mother') }}"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Child's name</label>
                                            <input type="text" class="form-control" name="child" value="{{ old('child') }}"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Phone number (<small> This is where sms will be sent to per intervals</small>)</label>
                                            <input type="text" class="form-control" name="phone_number" value="{{ old('phone_number') }}"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Child's Date of birth</label>
                                            <input type="date" class="form-control" name="dob"  value="{{ old('dob') }}"/>
                                        </div>

                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Child's Gender</label>
                                            <select name="gender" class="form-control">
                                                @foreach ($languages as $gender) 
                                                    <option value="{{ $gender }}"> {{ ucfirst($gender) }} </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <button type="button" id="vaccination_btn" class="btn btn-info" onclick="return ajaxFormRequest('#vaccination_btn','#vaccination_form','/vaccination/request','POST','#vaccination_status','Submit','no')">Submit </button>
                                        <div style="clear:both"></div>
                                        <br/>
                                        <div id="vaccination_status" align="center"></div>
                                        
                                    </form>
                                    <div style="clear:both"></div>
                                    <div id="reg-status" align="center"></div>
                                </div>
                            </div>
                            <br/><br/><br/><br/>
                        </div>
                    </div>
                    
            </div>
        </div>
    </section>


@endsection
