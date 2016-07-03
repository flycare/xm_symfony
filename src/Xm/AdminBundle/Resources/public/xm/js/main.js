(function ($) {
    $.getUrlParam = function (name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if (r != null) return unescape(r[2]);
        return null;
    }
    $.showGlobalNotify = function (content) {
        $("#global-notify").find(".modal-body").html(content);
        $('#global-notify').modal();
        return false;
    }
    $.showGlobalConfirm = function (content) {
        $("#global-confirm").find(".modal-body").html(content);
        $('#global-confirm').modal();
        $(".ok").unbind();
        return false;
    }
    $.hideGlobalConfirm = function (content) {
        $('#global-confirm').modal('hide');
        return false;
    }
    $.loadingShow = function () {
        $('#global-loading').modal();
    }
    $.loadingHide = function () {
        $('#global-loading').modal('hide');
    }
})(jQuery)