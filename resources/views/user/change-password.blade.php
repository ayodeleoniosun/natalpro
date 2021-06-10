@extends('user.includes.app')

@section('title')
    Natalpro | User | Change Password
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">Change Password</h3>
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
                    <h3> Update Password </h3> <hr/>

                    <form class="form-horizontal" id="settings-form" action="{{ route('user.change-password.update') }}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Current Password</label>
                            <input type="password" class="form-control" name="current_password"/>
                            @error('current_password')
                                <div class="text-danger"> {{ $message }} </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="control-label">New Password</label>
                            <input type="password" class="form-control" name="new_password"/>
                            @error('new_password')
                                <div class="text-danger"> {{ $message }} </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Confirm New Password</label>
                            <input type="password" class="form-control" name="new_password_confirmation"/>
                            @error('new_password_confirmation')
                                <div class="text-danger"> {{ $message }} </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-info"><i class="fa fa-check"></i> Change Password </button> <br/>
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
