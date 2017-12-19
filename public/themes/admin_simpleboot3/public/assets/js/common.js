$(function () {
    var common = {
        init: function () {

        },
        //弹出成功通知
        success: function (msg, callback) {
            $.notify({
                // options
                message: msg
            }, {
                // settings
                delay: 1000,
                type: 'success',
                onClosed: callback
            });

        },
        //弹出失败通知
        error: function (msg, callback) {
            $.notify({
                // options
                message: msg
            }, {
                // settings
                delay: 3000,
                type: 'danger',
                onClosed: callback
            });
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
        var that = $(this);
        var text = that.text();
        var location_url = $(this).attr('location_url');
        that.html('提交中 <i class="fa fa-spinner fa-pulse"></i>').attr('disabled',true);
        $(".ajax-form").ajaxSubmit({
            success: function (data) {
                if (data.code === 1) {
                    common.success(data.msg);
                    that.html(text).attr('disabled',false);
                    setTimeout(function () {
                        if (location_url !== undefined && location_url !== null && location_url !== '') {
                            location.href = location_url;
                        } else {
                            location.reload();
                        }
                    }, 1000);
                } else {
                    that.html(text).attr('disabled',false);
                    common.error(data.msg);
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