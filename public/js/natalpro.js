var idleTime = 0;

function payWithPaystackx(chat = null, email,phone,fullname,amount,ref_id) {
    
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
            //key: 'pk_test_2bd969a319c8ca9352f5d2bda30d202d97ec490c',
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
              window.location = "/portal/pregnant-nursing-women/chats"
            }
        });
        handler.openIframe();
    }
}

function payx(btn, success_url, error_url, status, data, email,phone,fullname,amount,ref_id) {
    ajaxLoadingRequest(success_url,status,data,'POST');
}

function pay(btn, success_url, error_url, status, data, email,phone,fullname,amount,ref_id) {
    
    if(email == "" || phone == "" || fullname == "" || amount == "" || ref_id == "") {
        alert("Please fill all fields");
        return false;
    } else {
        $(btn).attr('disabled', 'disabled');
        $(btn).html('Please wait ...');
        var fee = (1.5/100)*amount;
        var the_amount = eval(amount)+eval(fee);
        var paystack_amount = the_amount*100;
        var the_amount = Math.ceil(paystack_amount);
        
        var handler = PaystackPop.setup({
            key: 'pk_live_e6f6cdd378488be92b712074fb3c4d24bddf8483',
            //key: 'pk_test_2bd969a319c8ca9352f5d2bda30d202d97ec490c',
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
                    ajaxLoadingRequest(success_url,status,data,'POST')
                } else {
                    return false;
                }
            },
            onClose: function(){
              alert('Payment declined');
              window.location = error_url;
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

theNextBtn = (current_div,next_div) => {

    let user_type = $("#user_type").val();
    
    if(user_type == "") {
        alert("Select a user type before you proceed");
        $("#user_type").focus();
    } else {
        $(current_div).hide("fast");
        $(next_div).show("fast");
        $("html,body").animate({ scrollTop: 0 }, "fast");
    }
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

    $("#message").on('keypress, keyup keydown blur', function() {

        if ($(this).val() == "") {
            document.getElementById('chat-btn').style.display = "none";
        } else {
            document.getElementById('chat-btn').style.display = "block";
        }
    });

    $("#pm_message").on('keypress, keyup keydown blur', function() {

        if ($(this).val() == "") {
            document.getElementById('response_btn').style.display = "none";
        } else {
            document.getElementById('response_btn').style.display = "block";
        }
    });

    $("#user_type").change(function () {
        let user_type = $(this).val();
        $("#step_two").hide("fast");
        
        if (user_type == "pregnant-woman") {
            $("#normal_continue_btn, #normal_prev_btn").show("fast");
            $("#hidden_continue_btn, #hidden_prev_btn").hide("fast");
        } else {
            $("#normal_continue_btn, #normal_prev_btn").hide("fast");
            $("#hidden_continue_btn, #hidden_prev_btn").show("fast");
        }
    });

    $("#photo").change(function() {
        $("#preview_div").show('fast');
        previewImage(this);
    });


});

translateThis = (btn, submit_btn, english_val, status) => {

    $(submit_btn).hide("fast");
    $(btn).attr("disabled", "disabled");
    $(btn).html("Please wait ...");

    let message = $(english_val).val();
    let data = "message="+message;
    let translate = ajaxLoadingRequest('/portal/controlling-room-admin/translate-vaccination', status, data, 'POST');

}

updateTranslate = (btn, submit_btn, english_val, status, interval) => {

    $(submit_btn).hide("fast");
    $(btn).attr("disabled", "disabled");
    $(btn).html("Please wait ...");

    let message = $(english_val).val();
    let data = "message="+message+"&interval="+interval;
    let translate = ajaxLoadingRequest('/portal/controlling-room-admin/translate-vaccination', status, data, 'POST');

}

getMessagePages = (msg_div, pages_count) => {

    // var count_pages = $("#count_pages, #count_yoruba_pages, #count_igbo_pages, #count_hausa_pages");
    
    // $("#sample_english_message, #sms_yoruba, #sms_hausa, #sms_igbo, #update_sample_english_message");

    var count_pages = $(pages_count);
    var msg_txt_len = $(msg_div).val().length;
    var sms_char = 160;
    var pages = msg_txt_len/sms_char;
    var pages = Math.ceil(pages);
    var data = "pages="+pages;

    if(pages == 1) {
        count_pages.html("<b>"+msg_txt_len+"</b> characters = <b>"+pages+"</b> page <br/><b>"+pages+"</b> unit will be deducted per page");
    }
    else if(pages > 1) {
        count_pages.html("<b>"+msg_txt_len+"</b> characters = <b>"+pages+"</b> pages <br/> <b>"+pages+"</b> units will be deducted per page");
    }
}


$("#sample_english_message").on('keypress keyup keydown blur mouseleave', function(event) {    
    if(event.keyCode == 13) {
        event.preventDefault();
    }
    
    getMessagePages(this, "#count_pages");
});


$("#sms_yoruba").on('keypress keyup keydown blur mouseleave', function(event) {    
    if(event.keyCode == 13) {
        event.preventDefault();
    }
    
    getMessagePages(this, "#count_yoruba_pages");
});


$("#sms_igbo").on('keypress keyup keydown blur mouseleave', function(event) {    
    if(event.keyCode == 13) {
        event.preventDefault();
    }
    
    getMessagePages(this, "#count_igbo_pages");
});


$("#sms_hausa").on('keypress keyup keydown blur mouseleave', function(event) {    
    if(event.keyCode == 13) {
        event.preventDefault();
    }
    
    getMessagePages(this, "#count_hausa_pages");
});


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
                success:function(response) {
                    status.fadeIn("fast");
                    if (response.status == 'success') {
                        $(form).trigger("reset");
                        status.html("<p class='text-success'>"+response.message+"</p>");
                    } else {
                        status.html("<p class='text-danger'>"+response.message+"</p>");
                    }
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
    
    if(type == "pregnant-woman" || type == "nursing-mother") {
        window.location="/portal/controlling-room-admin/pregnant-nursing-women/chats/"+user_id;
    } else {
        window.location="/portal/controlling-room-admin/natal-nurses/chats/"+user_id;
    }
}

forumRequests = (user_type,type,id) => {
    var data = "id="+id;
    
    if(type == "delete-comment" || type == "nurse-delete-comment" || type == "admin-delete-comment") {
        var confirm = window.confirm('Delete comment?');

        if(confirm) {
            if(user_type == "admin") {
                ajaxLoadingRequest('/portal/controlling-room-admin/forum-requests/operation/'+type,'#the-status'+id,data,'POST');
            } else if(user_type == "patient") {
                ajaxLoadingRequest('/portal/pregnant-nursing-women/forum-requests/operation/'+type,'#the-status'+id,data,'POST');
            } else if(user_type == "nurse") {
                ajaxLoadingRequest('/portal/natal-nurse/forum-requests/operation/'+type,'#the-status'+id,data,'POST');
            }
        }
    } else {
        if(user_type == "admin") {
            ajaxLoadingRequest('/portal/controlling-room-admin/forum-requests/operation/'+type,'#the-status'+id,data,'POST');
        } else if(user_type == "patient") {
            ajaxLoadingRequest('/portal/pregnant-nursing-women/forum-requests/operation/'+type,'#the-status'+id,data,'POST');
        } else if(user_type == "nurse") {
            ajaxLoadingRequest('/portal/natal-nurse/forum-requests/operation/'+type,'#the-status'+id,data,'POST');
        }
    }
}

smsSampleRequest = (type,interval) => {
    
    var data = "type="+type+"&interval="+interval;
    ajaxLoadingRequest('/portal/controlling-room-admin/vaccination-sms-sample-requests/operation/'+type,'#sms-status'+interval,data,'POST');
}

smsRequest = (type,id) => {
    var data = "type="+type+"&id="+id;
    
    if (type == "view") {
        ajaxLoadingRequest('/portal/controlling-room-admin/vaccination-sms-requests/operation/'+type,'#sms-status'+id,data,'POST');
    } else if (type == "user-view") {
        ajaxLoadingRequest('/portal/pregnant-nursing-women/vaccination-sms-requests/operation/'+type,'#sms-status'+id,data,'POST');
    }
}

bulkSmsRequest = (id) => {
    ajaxLoadingRequest('/portal/controlling-room-admin/bulk-sms/view/'+id,'#sms-status'+id,'','GET');
}

nurseRequest = (type,req_id) => {
    
    if(type == "decline") {
        var confirm = window.confirm('Decline request?');

        if(confirm) {
            var data = "req_id="+req_id;
            ajaxLoadingRequest('/portal/controlling-room-admin/nurse-requests/operation/'+type,'#assign-status'+req_id,data,'POST');
        }
    } else {
        var data = "req_id="+req_id;
        ajaxLoadingRequest('/portal/controlling-room-admin/nurse-requests/operation/'+type,'#assign-status'+req_id,data,'POST');
    }
}

viewFeedbacks = (type,req_id) => {
    var data = "type="+type+"&req_id="+req_id;
    
    if(type == "admin") {
        ajaxLoadingRequest('/portal/controlling-room-admin/chats/view-feedback','#feedback-status'+req_id,data,'POST');
    } else if(type == "patient") {
        ajaxLoadingRequest('/portal/pregnant-nursing-women/chats/view-feedback','#feedback-status'+req_id,data,'POST');
    } else if(type == "nurse") {
        ajaxLoadingRequest('/portal/natal-nurse/chats/view-feedback','#feedback-status'+req_id,data,'POST');
    }
}