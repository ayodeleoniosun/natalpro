<div id="main-wrapper">
    
    <header class="topbar" style="background-color:#31516E"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <nav class="navbar top-navbar navbar-expand-md navbar-light">
            <div class="navbar-header" style="border-bottom:2px solid #ccc">
                <a class="navbar-brand" href="#">
                    <b>
                        <img src="{{ URL::asset('assets/images/logo-icon.png')}}" alt="homepage" class="img-responsive img-circle" style="max-width:40px"/>
                    </b>
                    <span> NatalPro </span> </a>
            </div> 

            <div class="navbar-collapse">

                <ul class="navbar-nav mr-auto mt-md-0">
                    
                    
                </ul>

                <ul class="navbar-nav my-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ URL::asset('/images/avatar.png') }}" class="img-responsive img-circle" style="max-width:30px;max-height:30px"/>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right scale-up">
                            <ul class="dropdown-user">
                                <li><a href="#" data-toggle="modal" data-toggle="tooltip" title="Change password" data-target="#changePasswordModal"><i class="ti-key"></i> Change Password</a></li>
                                <li><a href="{{ route('admin.logout') }}" onclick="return confirm('Logout?')"><i class="fa fa-power-off"></i> Logout</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
                
            </div>
        </nav>
    </header>
    
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <nav class="sidebar-nav">
                <ul id="sidebarnav">

                    <li> <a class="waves-effect waves-dark" href="http://www.natalpro.org" aria-expanded="false" target="_blank"><i class="mdi mdi-home"></i><span class="hide-menu">Home</span></a></li>

                    <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-medical-bag"></i><span class="hide-menu">Requests </span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{ route('user.vaccination.index', ['userType' => 'user']) }}">Vaccination Reminders</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>

    <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="changePasswordModalLabel1">Change Password</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-material" id="change_password_form" method="POST" onsubmit="return false">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Current Password</label>
                            <input type="password" class="form-control" name="current_password">
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="control-label">New Password</label>
                            <input type="password" class="form-control" name="new_password">
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Confirm New Password</label>
                            <input type="password" class="form-control" name="new_password_confirmation">
                        </div>

                        <div class="modal-footer" style="border:0px">
                            <div id="change_password_status"></div>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                             <button type="button" id="change_password_btn" onclick="return ajaxFormRequest('#change_password_btn','#change_password_form','/portal/controlling-room-admin/change-password','POST','#change_password_status','Change','no')" class="btn btn-info"><i class="fa fa-check"></i> Change </button>
                        </div>
                    </form>
                </div>    
            </div>
        </div>
    </div>
