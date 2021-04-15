const socket = io.connect('http://localhost:3000');
var idleTime = 0;

function payWithPaystack(chat, email,phone,fullname,amount,ref_id) {
    
    if(email == "" || phone == "" || fullname == "" || amount == "" || ref_id == "") {
        alert("Please fill all fields");
        return false;
    } else {
        var fee = (1.5*100)/amount;
        var the_amount = eval(amount)+eval(fee);
        var paystack_amount = the_amount*100;
        var the_amount = Math.ceil(paystack_amount);
        
        var handler = PaystackPop.setup({
            key: 'pk_test_22dcdb436c42028986efa17b9778de6df2402cdf',
            email: email,
            amount: the_amount,
            ref: ref_id,
            metadata: {
             custom_fields: [
                {
                    display_name: fullname,
                    variable_name: "mobile_number",
                    value: phone
                }
             ]
            },
            callback: function(response){

                if(response.status == "success") {
                    var data = "chat="+chat+"&amount="+the_amount;
                    ajaxLoadingRequest('/pregnant-nursing-women/pay-for-chat','#all_chats',data,'POST')
                } else {
                    return false;
                }
            },
            onClose: function(){
              alert('Payment declined');
              window.location = "/pregnant-nursing-women/chats"
            }
        });
        handler.openIframe();
    }
}


Print = (div) => {
    var details = document.getElementById(div).innerHTML;
    document.body.innerHTML = details;
    window.print();
}

NextBtn = (current_div,next_div) => {
    $(current_div).hide("fast");
    $(next_div).show("fast");
    $("html,body").animate({ scrollTop: 0 }, "fast");
}

PrevBtn = (current_div,prev_div) => {
    $(current_div).hide("fast");
    $(prev_div).show("fast");
    $("html,body").animate({ scrollTop: 0 }, "fast");
}

isCharNumber = (evt) => {
    var charCode = (evt.which) ? evt.which : event.keyCode;
        
    if (charCode > 31 && (charCode < 48 || charCode > 57) )
    { 
      return false;
    }
}

$(document).ready(function() {

    ajaxLoadingRequest('/nurse-activity-status/online','','','GET');

    $("#photo").change(function() {
        $("#preview_div").show('fast');
        previewImage(this);
    });

    //increment counter every 60 seconds
    idleInterval = setInterval(timerIncrement, 60000);

    $('body').on('mousemove keypress click', function(e) {
        idleTime = 0;
    });

});

timerIncrement = _ => {
    idleTime = idleTime+1;
    
    //after 10 minutes, render user as offline
    
    if(idleTime > 10) {
        ajaxLoadingRequest('/nurse-activity-status/offline','','','GET');
    }
}

previewImage = (input) => {

    if(input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $("#preview_pix").attr('src',e.target.result);
            
        }
        reader.readAsDataURL(input.files[0]);
    }
}

ajaxFormRequest = (btn_id,form,url,data_type,the_status,btn_title,file_upload) => {

    var btn = $(btn_id);
    var status = $(the_status);
    btn.attr("disabled",true);
    btn.html("Please wait ...");

    if(file_upload == "no") {
        var data = $(form).serialize();
        
        if(data_type == "POST") {
                        
            $.ajax(
            {
                type: data_type,
                url: url,
                data: data,
                
                headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(msg) {
                    status.fadeIn("fast");
                    status.html(msg);
                    btn.attr("disabled",false);
                    btn.html(btn_title);
                },
                error: function(the_error) {
                    btn.attr("disabled",false);
                    btn.html(btn_title);
                    status.fadeIn("fast");
                    status.html("<p style='color:red'>Request not successful. Try again.</p>");
                }
            });
        } else if(data_type == "GET") {

            $.ajax(
            {
                type: data_type,
                url: url,
                
                headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(msg) {
                    status.fadeIn("fast");
                    status.html(msg);
                    btn.attr("disabled",false);
                    btn.html(btn_title);
                },
                error: function(the_error) {
                    btn.attr("disabled",false);
                    btn.html(btn_title);
                    status.fadeIn("fast");
                    status.html("<p style='color:red'>Request not successful. Try again.</p>");
                }
            });
        }
    } else if(file_upload == "yes") {
        
        var data = new FormData($(form)[0]);
                
        $.ajax(
        {
            type: data_type,
            url: url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,

            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(msg) {
                status.fadeIn("fast");
                status.html(msg);
                btn.attr("disabled",false);
                btn.html(btn_title);
            },
            error: function(the_error) {
                btn.attr("disabled",false);
                btn.html(btn_title);
                status.fadeIn("fast");
                status.html("<p style='color:red'>Request not successful. Try again.</p>");
            }
        });
    }
}

ajaxFormSocketRequest = (form,url,the_status,file_upload) => {

    var data = $(form).serialize();
    var status = $(the_status);
    
    if($("#message").val() != "") {
    
        $.ajax(
        {
            type: 'POST',
            url: url,
            data: data,
            
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(msg) {
                $("#message").val('');
            },
            error: function(the_error) {
                status.fadeIn("fast");
                status.html("<p style='color:red'>Request not successful. Try again.</p>");
            }
        });
    }
}

ajaxLoadingRequest = (url,the_status,data,type) => {

    if(type == "GET") {
        var status = $(the_status);
        status.html("<svg class='circular' viewBox='25 25 50 50'><circle class='path' cx='50' cy='50' r='20' fill='none' stroke-width='2' stroke-miterlimit='10' /> </svg>");

        $.ajax(
        {
            type: type,
            url: url,
            
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(msg) {
                status.fadeIn("fast");
                status.html(msg);
                //window.scrollTo(0, document.body.scrollHeight);
            },
            error: function(the_error) {
                status.fadeIn("fast");
                status.html("<p style='color:red'>Request not successful. Try again.</p>");
            }
        });
    } 
    else if(type == "POST") {
        
        var status = $(the_status);
        status.html("<svg class='circular' viewBox='25 25 50 50'><circle class='path' cx='50' cy='50'   r='20' fill='none' stroke-width='2' stroke-miterlimit='10' /> </svg>");
        
        $.ajax(
        {
            type: type,
            url: url,
            data: data,
            cache: false,
            
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(msg) {
                status.fadeIn("fast");
                status.html(msg);
            },
            error: function(the_error) {
                status.fadeIn("fast");
                status.html("<p style='color:red'>Request not successful. Try again.</p>");
            }
        });
    }
}

ajaxNoLoadingRequest = (url,the_status,data,type) => {

    if(type == "GET") {
        var status = $(the_status);
        
        $.ajax(
        {
            type: type,
            url: url,
            
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(msg) {
                status.fadeIn("fast");
                status.html(msg);
            },
            error: function(the_error) {
                status.fadeIn("fast");
                status.html("<p style='color:red'>Request not successful. Try again.</p>");
            }
        });
    } 
    else if(type == "POST") {
        
        var status = $(the_status);
        
        $.ajax(
        {
            type: type,
            url: url,
            data: data,
            cache: false,
            
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(msg) {
                status.fadeIn("fast");
                status.html(msg);
            },
            error: function(the_error) {
                status.fadeIn("fast");
                status.html("<p style='color:red'>Request not successful. Try again.</p>");
            }
        });
    }
}

userChats = (type,user_id) => {
    
    if(type == "pregnant-nursing-women") {
        window.location="/controlling-room-admin/pregnant-nursing-women/chats/"+user_id;
    } else {
        window.location="/controlling-room-admin/natal-nurses/chats/"+user_id;
    }
}

forumRequests = (user_type,type,id) => {
    var data = "id="+id;
    
    if(type == "delete-comment" || type == "nurse-delete-comment" || type == "admin-delete-comment") {
        var confirm = window.confirm('Delete comment?');

        if(confirm) {
            if(user_type == "admin") {
                ajaxLoadingRequest('/controlling-room-admin/forum-requests/operation/'+type,'#the-status'+id,data,'POST');
            } else if(user_type == "patient") {
                ajaxLoadingRequest('/pregnant-nursing-women/forum-requests/operation/'+type,'#the-status'+id,data,'POST');
            } else if(user_type == "nurse") {
                ajaxLoadingRequest('/natal-nurse/forum-requests/operation/'+type,'#the-status'+id,data,'POST');
            }
        }
    } else {
        if(user_type == "admin") {
            ajaxLoadingRequest('/controlling-room-admin/forum-requests/operation/'+type,'#the-status'+id,data,'POST');
        } else if(user_type == "patient") {
            ajaxLoadingRequest('/pregnant-nursing-women/forum-requests/operation/'+type,'#the-status'+id,data,'POST');
        } else if(user_type == "nurse") {
            ajaxLoadingRequest('/natal-nurse/forum-requests/operation/'+type,'#the-status'+id,data,'POST');
        }
    }
}

nurseRequest = (type,req_id) => {
    var data = "req_id="+req_id;
    ajaxLoadingRequest('/controlling-room-admin/nurse-requests/operation/'+type,'#assign-status'+req_id,data,'POST');
}

viewFeedbacks = (type,req_id) => {
    var data = "type="+type+"&req_id="+req_id;
    
    if(type == "admin") {
        ajaxLoadingRequest('/controlling-room-admin/chats/view-feedback','#feedback-status'+req_id,data,'POST');
    } else if(type == "patient") {
        ajaxLoadingRequest('/pregnant-nursing-women/chats/view-feedback','#feedback-status'+req_id,data,'POST');
    } else if(type == "nurse") {
        ajaxLoadingRequest('/natal-nurse/chats/view-feedback','#feedback-status'+req_id,data,'POST');
    }
}

allowFeedback = (req_id, request_id) => {
    var confirm = window.confirm('Done with the chat and ready to receive feedback? ');

    if(confirm) {
        var data = "req_id="+req_id;
        $("#allow_feedback_btn"+request_id).attr('disabled','disabled').html('Please wait ...');
        $("#feedback-status"+request_id).html("Please wait while patient gives feedback about your service...");
        ajaxLoadingRequest('/natal-nurse/allow-feedback', '#feedback-status', data, 'POST');
    }
}

acceptChatRequest = (id) => {
    var confirm = window.confirm('Accept Request?');

    if(confirm) {
        var data = "id="+id;
        $("#payment_btn"+id).html('Please wait..').attr('disabled', 'disabled');
        $("#payment_status"+id).html("Patient is currently making payment. Please wait...");
        ajaxLoadingRequest('/natal-nurse/accept-chat-request','#online_nurses',data,'POST');
    }
}

//sockets

socket.on('user_offline', function (data) {
    data = jQuery.parseJSON(data);
});

socket.on('chat_online_nurses', function (data) {
    data = jQuery.parseJSON(data);
    
    if(data.count_nurses > 0){
        addValue(data.count_nurses+' nurses found ', 'count_online_nurses');
        ajaxLoadingRequest('/pregnant-nursing-women/request-online-nurses', '', '', 'GET');
    } else {
        addValue("<p class='text-danger'> All nurses are currently offline </p> <button onclick='return window.location='/pregnant-nursing-women/chat-with-nurse' class='btn btn-rounded btn-info'><i class='fa fa-refresh'></i> Refresh</button>", 'count_online_nurses');
    }
});

socket.on('online_nurses_request', function (data) {
    data = jQuery.parseJSON(data);
    
    var status = document.getElementById('online_nurses');
    
    status.innerHTML = "<br/><br/><br/><br/><svg class='circular' viewBox='25 25 50 50'><circle class='path' cx='50' cy='50' r='20' fill='none' stroke-width='2' stroke-miterlimit='10' /> </svg>";

    status.innerHTML+= "<br/> <div align='center'><small> Awaiting approval from any of the nurses currently online ... </small></div>";
});

socket.on('pay_msg', function (data) {
    alert(data);
});

socket.on('proceed_to_payment', function (data) {
    data = jQuery.parseJSON(data);
    alert(data);
    
    socket.emit('join', {
        patient:data.patient, 
        nurse: data.nurse
    });

    // payWithPaystack(data.chat, data.email,data.phone,data.fullname,data.amount,data.ref_id);
    // $("#patient_chat_requests").html("User is currently making payment. Please wait ...");
});

// socket.on('pay', function (data) {
//     data = jQuery.parseJSON(data);
//     alert(data.pay);
// });

socket.on('admin_private_chat', function (data) {
    data = jQuery.parseJSON(data);
    
    var current_user = localStorage.getItem('current_user_id');
    message = "<div class='chat-content'>";
    
    if(current_user == data.user_id) {
        message+= "<h5>You</h5>";
        message+= "<div class='box bg-light-inverse'>"+data.message+"</div>";
    } else {
        message+= "<h5>"+data.user+"</h5>";
        message+= "<div class='box bg-light-info'>"+data.message+"</div>";
    }
    message+= "</div>";
    message+= "<div class='chat-time'>"+data.date+"</div><br/>";
    
    (current_user == data.user_id) ? addMessage('#private_chat',message,"current") : addMessage('#private_chat',message);
});


socket.on('chat_sent', function (data) {
    data = jQuery.parseJSON(data);
    
    var current_user = localStorage.getItem('current_user_id');
    message = "<div class='chat-content'>";
    
    if(current_user == data.user) {
        //message+= "<h5>You</h5>";
        message+= "<div class='box bg-light-inverse'>"+data.message+"</div>";
    } else {
        //message+= "<h5>"+data.fullname+"</h5>";
        message+= "<div class='box bg-light-info'>"+data.message+"</div>";
    }
    message+= "</div>";
    message+= "<div class='chat-time'>"+data.date+"</div><br/>";
    
    (current_user == data.user) ? addMessage('#chat_messages',message,"current") : addMessage('#chat_messages',message);
});


function addValue(message, status) {
    document.getElementById(status).innerHTML = message;
}


function addMessage(status,message, type = null) {
    const li = document.createElement("li");
    const the_status = document.querySelector(status);
    li.className = (type == "current") ? 'reverse' : '';
    li.innerHTML = message;
    the_status.appendChild(li);
    window.scrollTo(0, the_status.scrollHeight);
}
