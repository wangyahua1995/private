
$(function(){
    var common = {
        init:function(){
            this.AjaxFormSubmit();
        },
        alert:function(msg,time){
            var html = "<div style='width:100%;position:fixed;bottom: 90px;text-align: center'>\n\
        <span class='alert' style='display: inline-block;line-height:24px;background-color:black;border-radius:5px;color:#fff;opacity:0.8;padding:10px 20px;border:black;text-align:center;font-size:14px;z-index:99999;'>"+msg+"</span>\n\
    </div>";
            $(".alert").remove();
            $("body").append(html);
            if(time == undefined){
                time = 1500;
            }
            setTimeout("common.hidden_alert()",time);
        },
        hidden_alert:function(){
            $(".alert").fadeOut("slow");
        },
        AjaxFormSubmit:function(){
            $(document).on('click','.jq-ajax',function(){
                $(".ajax-form").ajaxSubmit({
                    success:function(data){
                        if(data.code === 1){
                            common.alert(data.msg);
                            setTimeout(function(){
                                //location.href = "{:url('Customer/index')}";
                            },1000);
                        } else {
                            common.alert(data.msg);
                        }
                    }
                });
            })
        }
    }
    common.init();
});