;(function ($) {
    $.fn.extend({
        //层居中
        center: function (settings) {
            settings = $.extend({'fixed':true},settings);
            return this.each(function() {
                var top = ($(window).height() - $(this).outerHeight()) / 2;
                var left = ($(window).width() - $(this).outerWidth()) / 2;
                if(settings.fixed){
                    $(this).css({position:'fixed', margin:0, top:top,left:left});
                }else{
                    $(this).css({
                        position:'absolute',
                        margin:0,
                        top:top+$(document).scrollTop(),
                        left:left+$(document).scrollLeft()
                    });
                }
            });
        },
        //层可拖动
        dragable:function(options){
            options = $.extend({},options);
            var self = this;
            var mouse = {x:0,y:0};
            $(this).css({'position':'absolute'});
            this.moveDiv = function(event){
                var e = window.event || event;
                var position = $(self).offset();
                var top = position.top + (e.clientY - mouse.y);
                var left = position.left + (e.clientX - mouse.x);
                $(self).css({top:top,left:left});
                mouse.x = e.clientX;
                mouse.y = e.clientY;
            }
            var handle = options.handle ? $(options.handle) : $(this);
            handle.mousedown(function(event){
                var e = window.event || event;
                mouse.x = e.clientX;
                mouse.y = e.clientY;
                $(document).bind('mousemove',self.moveDiv);
                handle.css({'cursor': 'move'});
            });
            $(document).mouseup(function(){
                $(document).unbind('mousemove',self.moveDiv);
                handle.css({'cursor': 'default'});
            });
        },
        //当前位置插入内容
        insertContent: function(myValue, t) {
            var $t = $(this)[0];
            if (document.selection) { //ie
                this.focus();
                var sel = document.selection.createRange();
                sel.text = myValue;
                sel.moveStart('character', -l);
                var wee = sel.text.length;
                if (arguments.length == 2) {
                    var l = $t.value.length;
                    sel.moveEnd("character", wee + t);
                    t <= 0 ? sel.moveStart("character", wee - 2 * t - myValue.length) : sel.moveStart("character", wee - t - myValue.length);
                    sel.select();
                }
            } else if ($t.selectionStart || $t.selectionStart == '0') {
                var startPos = $t.selectionStart;
                var endPos = $t.selectionEnd;
                var scrollTop = $t.scrollTop;
                $t.value = $t.value.substring(0, startPos) + myValue + $t.value.substring(endPos, $t.value.length);
                this.focus();
                $t.selectionStart = startPos + myValue.length;
                $t.selectionEnd = startPos + myValue.length;
                $t.scrollTop = scrollTop;
                if (arguments.length == 2) {
                    $t.setSelectionRange(startPos - t, $t.selectionEnd + t);
                    this.focus();
                }
            }
            else {
                this.value += myValue;
                this.focus();
            }
        }
    });
})(jQuery);
