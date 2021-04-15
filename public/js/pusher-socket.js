var pusher = new Pusher('5d72b785dda223a8d44b', {
  cluster: 'eu',
});

//console.log(pusher.connection.state);

var patient = localStorage.getItem('patient');
var user_offline = pusher.subscribe('user_offline');
var proceed_to_payment = pusher.subscribe('proceed_to_payment');
var accept_btn = pusher.subscribe('accept_btn');
var remove_chat_request = pusher.subscribe('remove_chat_request');

function payWithPaystack(chat = null, email,phone,fullname,amount,ref_id) {
    
    if(email == "" || phone == "" || fullname == "" || amount == "" || ref_id == "") {
        alert("Please fill all fields");
        return false;
    } else {
        var fee = (1.5/100)*amount;
        var the_amount = eval(amount)+eval(fee);
        var paystack_amount = the_amount*100;
        var the_amount = Math.ceil(paystack_amount);
        
        var handler = PaystackPop.setup({
            key: 'pk_live_e6f6cdd378488be92b712074fb3c4d24bddf8483',
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
                    ajaxLoadingRequest('/portal/pregnant-nursing-women/pay-for-chat','#all_chats',data,'POST')
                } else {
                    return false;
                }
            },
            onClose: function(){
                alert('Payment declined');
                var data = "chat="+chat;
                ajaxLoadingRequest('/portal/pregnant-nursing-women/remove-chat-request','#all_chats',data,'POST')
            }
        });
        handler.openIframe();
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

allowFeedback = (req_id, request_id) => {
    var confirm = window.confirm('Done with the chat and ready to receive feedback? ');

    if(confirm) {
        var data = "req_id="+req_id;
        $("#allow_feedback_btn"+request_id).attr('disabled','disabled').html('Please wait ...');
        $("#feedback-status"+request_id).html("Please wait while patient gives feedback about your service...");
        ajaxLoadingRequest('/portal/natal-nurse/allow-feedback', '#feedback-status', data, 'POST');
    }
}

acceptChatRequest = (id) => {
    var confirm = window.confirm('Accept Request?');

    if(confirm) {
        var data = "id="+id;
        $("#payment_btn"+id).html('Please wait..').attr('disabled', 'disabled');
        $("#payment_status"+id).html("Patient is currently making payment. Please wait...");
        ajaxLoadingRequest('/portal/natal-nurse/accept-chat-request','#online_nurses',data,'POST');

    }
}

//pusher

// chat_online_nurses.bind('chat_online_nurses', function(data) {
    
//     if(data.count_nurses > 0) {
//         addValue(data.count_nurses+' nurses found ', 'count_online_nurses');
//         ajaxLoadingRequest('/pregnant-nursing-women/request-online-nurses', '', '', 'GET');
//     } else {
//         addValue("<p class='text-danger'> All nurses are currently offline </p> <button onclick='return window.location='/pregnant-nursing-women/chat-with-nurse' class='btn btn-rounded btn-info'><i class='fa fa-refresh'></i> Refresh</button>", 'count_online_nurses');
//     }
// });

remove_chat_request.bind('remove_chat_request', function (data) {
    console.log(data);
    var row = document.getElementById("accept_div"+data.chat);
    row.parentNode.removeChild(row);
});

proceed_to_payment.bind('proceed_to_payment', function (data) {
    $("#payment_btn"+data.chat).html('Please wait..').attr('disabled', 'disabled');
    $("#payment_status"+data.chat).html("Patient is currently making payment. Please wait...");

    if(data.patient == patient) {
        payWithPaystack(data.chat, data.email,data.phone,data.fullname,data.amount,data.ref_id);
        $("#patient_chat_requests").html("User is currently making payment. Please wait ...");
    }
});

function addValue(message, status) {
    document.getElementById(status).innerHTML = message;
}

function addMessage(status,message, type = null, scroll_status = null) {
    const li = document.createElement("li");
    let the_status = document.getElementById(status);
    li.className = (type == "current") ? 'reverse' : '';
    li.innerHTML = message;
    the_status.appendChild(li);
    the_status.scrollTop = the_status.scrollHeight;

    if(scroll_status == null) {

    } else {
        let the_scroll_status = document.getElementById(scroll_status);
        the_scroll_status.scrollTop = the_scroll_status.scrollHeight;
    }

}
