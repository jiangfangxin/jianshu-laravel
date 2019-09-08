$(".post-audit").click(function (e) {
    var target = $(e.target);
    var post_id = target.attr("post-id");
    var status = target.attr("post-action-status");
    
    $.ajax({
        url: "/admin/posts/" + post_id + "/status",
        method: "POST",
        data: {"status": status},
        dataType: "json",
        headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')}
    }).done(function (data) {
        if (data.error != 0) {
            alert(data.msg);
        } else {
            target.parent().parent().remove();
        }
    });
})

$(".resource-delete").click(function (e) {
    if (confirm("确定要执行删除操作吗？") == false) {
        return;
    }
    
    var target = $(e.target);
    e.preventDefault();
    var url = target.attr("delete-url");
    $.ajax({
        url: url,
        method: "POST",
        data: {"_method": "DELETE"},
        dataType: "json",
        headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')}
    }).done(function (data) {
        if (data.error != 0) {
            alert(data.msg);
            return;
        } else {
            window.location.reload();
        }
    });
});
