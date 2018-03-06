<textarea title="" name="{{$name}}" id="kindeditor" style="width:100%; height:400px;visibility:hidden; display:none;">{{$content}}</textarea>
<link rel="stylesheet" href="/kindeditor/themes/default/default.css" />
<script charset="utf-8" src="/kindeditor/kindeditor-min.js"></script>
<script charset="utf-8" src="/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript">
    (function () {
        var keditor = KindEditor.create('#kindeditor', {
            allowFileManager : true,
            items : [
                'source', '|', 'undo', 'redo', '|', 'template', 'code', 'cut', 'copy', 'paste',
                'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
                'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
                'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
                'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
                'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'multiimage',
                'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
                'anchor', 'link', 'unlink'
            ],
            afterBlur: function () {this.sync();},
            uploadJson : "/plugin/kindeditor/upload",
            fileManagerJson:"/plugin/kindeditor/manager}",
            extraFileUploadParams:@json($params)
        });
    })();
</script>
