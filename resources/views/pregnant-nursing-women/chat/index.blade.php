<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use DB;
use App\MyLib\Dates;
use App\MyLib\Misc;
use App\MyLib\Query;
?>

@extends('pregnant-nursing-women.pusher-app')

@section('title')
    Natalpro | Pregnant and Nursing Women | Initiate chat with a Nurse
@endsection

@section('content')

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">Initiate chat with a Nurse</h3>
            </div>
        </div>
        
        <div class="container-fluid">
            
            <div class="card">
                <div class="card-body">

                    <script type="text/javascript">
                        $(document).ready(function() {
                            ajaxLoadingRequest('/portal/pregnant-nursing-women/chat-online-nurses', '#count_online_nurses', '', 'GET');
                        });
                    </script>

                    <div id="all_online_nurses"></div> 

                    <div id="count_online_nurses" align="center"></div> 
                    
                    <div id="online_nurses"></div> 

                    <div id="all_chats"></div> 

                </div>
            </div>

        </div>

        <div style="margin-top:100%"></div>

        @include('pregnant-nursing-women.footer')
    </div>
</div>
    
@endsection
