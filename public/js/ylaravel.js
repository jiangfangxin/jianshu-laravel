var editor = new wangEditor('#content-editor');
if (editor.customConfig) {
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
}

$(".preview_input").change(function(event) {
    var file = event.currentTarget.files[0];
    var url = window.URL.createObjectURL(file);
    $(event.target).next(".preview_img").attr("src", url);
});

$(".like-button").click(function (e) {
    var $target = $(e.target);
    var target_id = $target.attr("like-user");
    var hasStared = $target.attr("like-value");
    if (hasStared == 1) {
        // 取消关注
        $.ajax({
            url: "/user/" + target_id +"/unfan",
            method: "POST",
            headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')}
        }).done(function (data) {
            if (data.err == 0) {
                $target.attr("like-value", 0);
                $target.text("关注");
            } else {
                alert(data.msg);
            }
        }).fail(function (err) {
            alert(err);
        });
    } else {
        // 关注
        $.ajax({
            url: "/user/" + target_id +"/fan",
            method: "POST",
            headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')}
        }).done(function (data) {
            if (data.err == 0) {
                $target.attr("like-value", 1);
                $target.text("取消关注");
            } else {
                alert(data.msg);
            }
        }).fail(function (err) {
            alert(err);
        });
    }
});

