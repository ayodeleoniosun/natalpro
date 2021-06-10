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

        <div class="flash-message">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session('alert-' . $msg))
                    <div class="container">
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
        
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h3> Update Settings </h3> <hr/>

                    <form class="form-horizontal" id="settings-form" action="{{ route('admin.settings.update') }}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label> Vaccination Price </label>
                                <input class="form-control" type="text" name="vaccination_amount" required="" onkeypress="return isCharNumber(event)" value="{{$settings->vaccination_amount}}"/> </div>
                                @error('vaccination_amount')
                                    <div class="text-danger"> {{ $message }} </div>
                                @enderror
                        </div>
                        
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label> Kit Price </label>
                                <input class="form-control" type="text" name="kit_amount" required="" onkeypress="return isCharNumber(event)" value="{{$settings->kit_amount}}"/> </div>
                                @error('kit_amount')
                                    <div class="text-danger"> {{ $message }} </div>
                                @enderror
                        </div>
                        
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label> Vaccination reminder welcome message </label> <br/>
                                <small> (<i> Ensure that this is not more than a page in order to conserve SMS units </i>)</small>
                                <textarea name="welcome_message" id="sample_english_message" class="form-control" rows="5">{{$settings->welcome_message}}</textarea>
                                @error('welcome_message')
                                    <div class="text-danger"> {{ $message }} </div>
                                @enderror
                                <small id="count_pages"></small>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-info"><i class="fa fa-check"></i> Save changes </button> <br/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('admin.includes.footer')
    </div>
</div>
@endsection
