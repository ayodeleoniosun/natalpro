@extends('admin.includes.app')

@section('title')
    Natalpro | All Users
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">Users <span class="badge badge-info">{{ $users->count() }} </span></h3>
            </div>
        </div>
        
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    @if($users->count()  == 0) 
                        <div class="container">
                            <div class="alert alert-danger"> No user yet </div>
                        </div>
                    @else
                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Type</th>
                                        <th>Fullname</th>
                                        <th>Phone</th>
                                        <th>Location</th>
                                        <th>Reg On</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td> {{$loop->iteration}} </td>
                                            <td> {{ $user->type }} </td>
                                            <td><a href="{{ route('admin.user.profile', ['id' => $user->id]) }}" class="text-info"> {{ $user->full_name }}</a></td>
                                            <td><a href="tel:{{ $user->phone_number }}">{{ $user->phone_number }}</a></td>
                                            <td> {{ $user->location }}</td>
                                            <td> {{ $user->created_at }}</td>
                                            <td><span class="{{ $user->status['color'] }}"> {{ $user->status['label'] }} </span> </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                                                        
                        <div style="clear:both"></div>
                        <br/>   
                    @endif
                </div>
            </div>
        </div>
        
        @include('admin.includes.footer')
    </div>
</div>
    
@endsection
