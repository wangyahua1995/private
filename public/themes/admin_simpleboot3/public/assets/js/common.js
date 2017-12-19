$(function () {
    var common = {
        init: function () {

        },
        alert: function (msg, time) {
            var html = "<div style='width:100%;position:fixed;bottom: 90px;text-align: center'>\n\
        <span class='alert' style='display: inline-block;line-height:24px;background-color:black;border-radius:5px;color:#fff;opacity:0.8;padding:10px 20px;border:black;text-align:center;font-size:14px;z-index:99999;'>" + msg + "</span>\n\
    </div>";
            $(".alert").remove();
            $("body").append(html);
            if (time == undefined) {
                time = 1500;
            }
            setTimeout(hidden_alert, time);
        },
        serializeJson:function($form){
            var serializeObj = {};
            $($form.serializeArray()).each(function () {
                if (serializeObj[this.name] === undefined) {
                    serializeObj[this.name] = this.value;
                }
                else if (typeof serializeObj[$form.name] === 'object') {
                    serializeObj[this.name].push(this.value);
                }
                else {
                    var old_value = serializeObj[$form.name];
                    serializeObj[this.name] = [];
                    serializeObj[this.name].push(old_value);
                    serializeObj[this.name].push(this.value);
                }
            });
            return serializeObj;
        }
    };
    common.init();


    function hidden_alert() {
        $(".alert").fadeOut("slow");
    }

    /**
     * form通用提交数据
     */
    $(document).on('click', '.jq-ajax', function () {
        var location_url = $(this).attr('location_url');
        $(".ajax-form").ajaxSubmit({
            success: function (data) {
                if (data.code === 1) {
                    common.alert(data.msg);
                    setTimeout(function () {
                        if (location_url !== undefined && location_url !== null && location_url !== '') {
                            location.href = location_url;
                        } else {
                            location.reload();
                        }
                    }, 1000);
                } else {
                    common.alert(data.msg);
                }
            }
        });
    });

    /**
     * 支持列表页面通用搜索事件封装
     *
     * 使用的时候页面　form添加 form-search-tool类
     * table　添加 J_tableTool
     */
    $('body').on('submit', 'form.J_formSearchTool', function () {
        var tableObj = $('.J_tableTool[data-table-id]');
        var formParams = common.serializeJson($(this));
        console.log(formParams);
        tableObj.bootstrapTable('refreshOptions', {
            queryParams: function (params) {
                params = $.extend(params, formParams);
                return params;
            }, pageNumber: 1
        });
        return false;
    });
});