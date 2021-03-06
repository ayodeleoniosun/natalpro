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

                    <div class="flash-message">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session('alert-' . $msg))
                                <div class="row">
                                <div class="col-sm-12">
                                    <div class="alert alert-{{ $msg }} alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    {{ Session('alert-' . $msg) }}
                                    </div>
                                </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    
                    <div class="row" id="validation">
                        <h3 class="container" align="center">Register For Our Vaccination Reminder!</h3> <br/>
                        <form class="form-horizontal form-material container" id="vaccination_form" method="POST" action="{{ route('vaccination.request') }}">
                            {{csrf_field()}}
                            <br/> 
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">Mother's name</label>
                                <input type="text" class="form-control" name="mother" value="{{ old('mother') }}"/>
                                @error('mother')
                                    <div class="text-danger"> {{ $message }} </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">Child's name</label>
                                <input type="text" class="form-control" name="child" value="{{ old('child') }}"/>
                                @error('child')
                                    <div class="text-danger"> {{ $message }} </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">Phone number (<small> This is where sms will be sent to per intervals</small>)</label>
                                <input type="text" class="form-control" name="phone_number" value="{{ old('phone_number') }}"/>
                                @error('phone_number')
                                    <div class="text-danger"> {{ $message }} </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">Child's Date of birth</label>
                                <input type="date" class="form-control" name="dob"  value="{{ old('dob') }}"/>
                                @error('dob')
                                    <div class="text-danger"> {{ $message }} </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="recipient-name" class="control-label">Child's Gender</label>
                                <select name="gender" class="form-control">
                                    <option value="" disabled> -- Select gender -- </option>
                                    @foreach ($genders as $gender) 
                                        <option value="{{ $gender }}" @if( old('gender')  == $gender) selected="selected" @endif> {{ ucfirst($gender) }} </option>
                                    @endforeach
                                </select>
                                @error('gender')
                                    <div class="text-danger"> {{ $message }} </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="control-label">Language to receive SMS with</label>
                                <select name="language" class="form-control" >
                                    <option value="" disabled> -- Select language -- </option>
                                    @foreach ($languages as $language) 
                                        <option value="{{ $language }}" @if( old('language')  == $language) selected="selected" @endif> {{ ucfirst($language) }} </option>
                                    @endforeach
                                </select>
                                @error('language')
                                    <div class="text-danger"> {{ $message }} </div>
                                @enderror
                            </div>
                            
                            <button type="submit" id="vaccination_btn" class="btn btn-info btn-block">Submit </button>
                        </form>
                    </div>
                    <div style="clear:both"></div>
                    <br/>
                    <div class="pull-right"> Already have an account? <a href="{{ route('user.index') }}" class="text-info"> Login here</a> </div>
                </div>
            </div>
        </div>
        </div>
    </section>


@endsection
