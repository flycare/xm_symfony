$(document).ready(function(){
    $("body").on("click",".create_menu",function(){
        var target = $("div.active").attr('id');
        if(target == 'navigation'){
            $('body').data('level','1');
        }else if(target == 'subpage'){
            $('body').data('level','2');
        }
        $("div#create_menu .menu_title").val('');
        $("div#create_menu .menu_weight").val('');
        $(".save_new_menu").removeAttr('disabled');
        $('#create_menu').modal();
    })

    $("body").on("click",".save_new_menu",function(){
        $(this).attr('disabled','disabled');
        var title = $("div#create_menu .menu_title").val();
        var weight = $("div#create_menu .menu_weight").val();
        var level = $('body').data('level');
        var data = {
            'title':title,
            'weight':weight,
            'level':level
        };
        $.ajax({
            type:'POST',
            url: createMenuUrl,
            data: data,
            success: function (data) {
                if (data.result == true) {
                    $('#create_menu').modal('hide');
                    $.showGlobalNotify("创建成功");
                    $("div#create_menu .menu_title").val('');
                    $("div#create_menu .menu_weight").val('');
                    window.location.reload();
                }
            },
            dataType: "json"
        })
    })

    $("body").on("click",".edit-menu",function(){
        var topDom = $(this).parent().parent();
        showProcess(topDom);
        return false;
    })

    $("body").on("click",".save-menu",function(){
        var topDom = $(this).parent().parent();
        var menuDom = topDom.find(".menu_input").find("input");
        var weightDom = topDom.find(".weight_input").find("input")
        var id = topDom.attr("data-id");
        var title = menuDom.val();
        var weight = weightDom.val();
        var data = {
            id:id,
            title:title,
            weight:weight
        };
        $.loadingShow();
        $.ajax({
            type:'POST',
            url: saveMenuUrl,
            data: data,
            success: function (data) {
                $.loadingHide();
                if (data.result == true) {
                    $.showGlobalNotify("保存成功");
                    window.location.reload();
                }
            },
            dataType: "json"
        })
    })

    $("body").on("click",".delete-menu",function(){
        $.showGlobalConfirm("确定删除导航菜单吗？");
        var topDom = $(this).parent().parent();
        var id = topDom.attr("data-id");
        $(".ok").click(function(){
            var data = {
                id:id
            };
            $.loadingShow();
            $.ajax({
                type:'POST',
                url: deleteMenuUrl,
                data: data,
                success: function(data) {
                    $.loadingHide();
                    if (data.result == true) {
                        $.showGlobalNotify("删除成功");
                        window.location.reload();
                    }
                },
                dataType: "json"
            })
        })
        return false;
    })

    function showProcess(topDom){
        topDom.find(".menu_title").hide();
        topDom.find(".weight_value").hide();
        var title = $.trim(topDom.find(".menu_title").html());
        var weight = $.trim(topDom.find(".weight_value").html());
        var menuDom = topDom.find(".menu_input").find("input");
        var weightDom = topDom.find(".weight_input").find("input");
        var saveButton = topDom.find(".save-menu");
        var editButton = topDom.find(".edit-menu");
        menuDom.val(title);
        weightDom.val(weight);
        menuDom.removeClass("hidden");
        weightDom.removeClass("hidden");
        saveButton.removeClass("hidden");
        editButton.addClass("hidden");
        return false;
    }
})