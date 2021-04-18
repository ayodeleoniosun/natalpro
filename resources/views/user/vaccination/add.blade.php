@extends('user.template')

@section('title')
    Natalpro | Vaccination
@endsection

@section('content')
    <section id="wrapper" style="margin-top:-30px">
        <div class="login-register" style="background-image:url(/assets/images/background/login-register.jpg);">
            <div class="the-login-box card">
                <div class="card-body">
                    <div align="center">
                        <a href="http://www.natalpro.org">
                            <img src="{{ URL::asset('assets/images/logo-icon.png')}}" alt="homepage" class="dark-logo" class="img-responsive img-thumbnail" style="width:100px"/>
                        </a>
                    </div>
                    <br/>

                    <div class="row" id="validation">
                        <h3 class="container" align="center">Register For Our Vaccination Reminder!</h3>
                        <form class="form-horizontal form-material container" id="vaccination_form" method="POST" onsubmit="return false">
                            {{csrf_field()}}
                            <br/> 
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
                                    @foreach ($genders as $gender) 
                                        <option value="{{ $gender }}"> {{ ucfirst($gender) }} </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="button" id="vaccination_btn" class="btn btn-info btn-block" onclick="return ajaxFormRequest('#vaccination_btn','#vaccination_form','/vaccination/request','POST','#vaccination_status','Submit','no')">Submit </button>
                            <br/>
                            
                            <div align="center">
                                <div id="vaccination_status" style="font-size:13px"></div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>


@endsection
