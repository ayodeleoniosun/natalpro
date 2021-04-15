@extends('public.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Chats</div>

                <script type="text/javascript">
                    $(document).ready(function() {
                        ajaxLoadingRequest('/portal/pregnant-nursing-women/chat-online-nurses', '#all_online_nurses', '', 'GET');
                    });
                </script>

                <div id="all_online_nurses"></div> 

                <div id="count_online_nurses" align="center"></div> 
                
                <div id="online_nurses"></div> 

                <div id="all_chats"></div> 
                
                <ul id="all-chats"></ul>

                <hr/>

                <form class="form-horizontal" id="chat-form" action="#" method="post" onsubmit="return false">
                        
                    {{csrf_field()}}

                    <div class="form-group">
                        <div class="col-xs-12">
                            <textarea name="message" id="message" class="form-control" rows="5"></textarea> 
                        </div>
                    </div>
                    
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-info btn-md btn-block" id="chat-btn" onclick="return ajaxFormRequest('#chat-btn','#chat-form','/portal/messages','POST','#chat-status','chat','no')">chat <i class="fa fa-sign-in"></i></button> <br/>
                            <div id='chat-status'></div>
                        </div>
                    </div>
                
                </form>
            </div>
        </div>
    </div>
</div>
@endsection