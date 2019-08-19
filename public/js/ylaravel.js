var editor = new wangEditor('#content-editor');
var $content = $('#content')
editor.customConfig.onchange = function (html) {
    // 监控变化，同步更新到 textarea
    $content.val(html)
}
editor.create()
// 初始化 textarea 的值
$content.val(editor.txt.html())
