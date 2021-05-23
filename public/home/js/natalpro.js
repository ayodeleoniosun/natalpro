Print = (div) => {
    var details = document.getElementById(div).innerHTML;
    document.body.innerHTML = details;
    window.print();
}

isCharNumber = (evt) => {
    var charCode = (evt.which) ? evt.which : event.keyCode;
        
    if (charCode > 31 && (charCode < 48 || charCode > 57) )
    { 
      return false;
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
                    status.html("<p style='color:red'>Unable to perform operation</p>");
                }
            });
        } else if(data_type == "GET") {
            alert(data_type);
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
                    status.html("<p style='color:red'>Unable to perform operation</p>");
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
                status.html("<p style='color:red'>Unable to perform operation</p>");
            }
        });
    }
}