var editor = new wangEditor('#content-editor');
editor.customConfig.debug = 1;
// 配置服务器端地址
editor.customConfig.uploadImgServer = '/posts/image/upload';
editor.customConfig.uploadFileName = 'wangEditorFile';
// 设置Header
editor.customConfig.uploadImgHeaders = {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
var $content = $('#content')
editor.customConfig.onchange = function (html) {
    // 监控变化，同步更新到 textarea
    $content.val(html)
}
editor.create();
// 初始化 textarea 的值
$content.val(editor.txt.html());
