var DSXUI = {
    message : function(settings){
        var opt = $.extend({
            type:'success',
            text:'操作完成'
        },settings);

        if(opt.type !== 'success' && opt.type !== 'error' && opt.type !== 'warning') opt.type = 'infomation';
        var icon;
        switch(opt.type) {
            case 'success':
                icon = '&#xe656;';
                break;
            case 'error':
                icon = '&#xe658;';
                break;
            case 'warning':
                icon = '&#xe662;';
                break;
            default : icon = '&#xe6e4;';
        }
        $("#dsxui-message-box").remove();
        var div = $('<div/>').addClass('dsxui-message-box').attr('id','dsxui-message-box');
        var con = $('<div/>').addClass('message-div message-'+opt.type).html('<div class="iconfont message-icon">'+icon+'</div><div class="message-text">'+opt.text+'</div>');
        div.html(con).appendTo(document.body).fadeIn('fast').center();
        if(opt.afterShow) opt.afterShow(div);
        setTimeout(function(){div.remove(); if(opt.afterClose) opt.afterClose(div);},2000);
    },
    success : function(text, callback){
        DSXUI.message({type:'success',text:text,afterClose:callback});
    },
    error : function(text,callback){
        DSXUI.message({type:'error',text:text,afterClose:callback});
    },
    warning : function(text,callback){
        DSXUI.message({type:'warning',text:text,afterClose:callback});
    },
    infomation : function(text,callback){
        DSXUI.message({type:'infomation',text:text,afterClose:callback});
    },
    confirm : function(selector,text,ok,cancel){
        $(selector).confirm({text:text,onConfirm:ok,onCancel:cancel});
    },
    loading : {
        isShow:false
    },
    showloading : function(text){
        text = text||'数据加载中...';
        var that = DSXUI.loading;
        that.overlayer = $("<div/>").addClass("dsxui-overlayer").appendTo(document.body);
        that.indicator = $('<div class="dsxui-loading-box" id="dsxui-loading-box"><span class="ico"></span>'+text+'</div>')
            .appendTo(document.body).center();
        that.isShow = true;
        that.close = function(){
            that.isShow = false;
            that.indicator.remove();
            that.overlayer.remove();
        }
        that.hide = function () {
            that.close();
        }
        return that;
    },
    hideloading : function () {
        if (DSXUI.loading.isShow) DSXUI.loading.close();
    },
    spinner:{
        isShow:false,
        hide:null
    },
    showSpinner : function(){
        var that = DSXUI.spinner;
        that.overlayer = $("<div/>").addClass("dsxui-overlayer").appendTo(document.body);
        that.indicator = $('<div class="dsxui-spinner" id="dsxui-spinner"></div>').appendTo(document.body).center();
        that.isShow = true;
        that.close = function(){
            that.isShow = false;
            that.indicator.remove();
            that.overlayer.remove();
        }
        that.hide = function () {
            that.close();
        }
        return that;
    },
    hideSpinner : function () {
        if (DSXUI.spinner.isShow) DSXUI.spinner.hide();
    },
    toast : {
        isShow:false,
        hide:null
    },
    showToast : function (text, duration, callback) {
        if (!duration) duration = 1500;
        var that = DSXUI.toast;
        if (that.isShow) {
            that.hide();
        }
        that.container = $("<div/>").addClass("dsxui-toast").attr('id', 'dsxui-toast')
            .append('<div class="dsxui-toast-content">'+text+'</div>')
            .appendTo(document.body).center();
        that.isShow = true;
        that.hide = function () {
            that.isShow = false;
            that.container.remove();
            if (callback) callback();
        }
        setTimeout(that.hide, duration);
    },
    hideToast : function () {
        if (DSXUI.toast.isShow) DSXUI.toast.hide();
    },
    dialog:function(settings){
        return new DSXDialog(settings);
    },
    showConfirm:function (title, text, callback, cancel) {
        if (!title) title = '删除确认';
        if (!text) text = '确认要删除此项目吗?';
        DSXUI.dialog({
            width:350,
            dragable:false,
            title:title,
            content:'<div style="font-size: 14px;">'+text+'</div>',
            onConfirm:function(dlg){
                dlg.close();
                if(callback) callback(dlg);
            },
            onCancel:function(dlg){
                if (cancel) cancel(dlg);
            }
        });
    },

    //图片选择器 新版
    showImagePicker:function (callback) {
        DSXUI.dialog({
            width:'780px',
            height:'520px',
            title:'图片空间',
            hideFooter:true,
            iframe:'/plugin/image',
            afterShow:function (dlg) {
                window.onPickedImage = function (response) {
                    dlg.close();
                    if (callback) callback(response);
                }
            },
            afterClose:function () {
                window.onPickedImage = null;
            }
        });
    }
}
