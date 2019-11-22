$(function(){
    // 固定布局
    var isFixed = localStorage.getItem('ace_state_id');
    if (isFixed === null) {
        localStorage.setItem('ace_state_id-navbar', '{"class":{"navbar-fixed-top":1}}');
        localStorage.setItem('ace_state_id-sidebar', '{"class":{"sidebar-fixed":1}}');
    }

    // 导航栏选中
    var urlData = {
        "/admin/permission/index": ["/admin/permission/index", "/admin/permission/create", "/admin/permission/show", "/admin/permission/update"],
        "/admin/role/index": ["/admin/role/index", "/admin/role/create", "/admin/role/show", "/admin/role/update"],
        "/admin/admin/index": ["/admin/admin/index", "/admin/admin/create", "/admin/admin/show", "/admin/admin/update"],
        "/admin/config/index": ["/admin/config/index", "/admin/config/create", "/admin/config/show", "/admin/config/update"],
        "/admin/config/setting": ["/admin/config/setting"],
        "/admin/tag/index": ["/admin/tag/index", "/admin/tag/create", "/admin/tag/show", "/admin/tag/update"],
        "/admin/article/index": ["/admin/article/index", "/admin/article/create", "/admin/article/show", "/admin/article/update"],
        "/admin/page/index": ["/admin/page/index", "/admin/page/create", "/admin/page/show", "/admin/page/update"]
    };
    var pathname = location.pathname;
    $.each(urlData, function(key,value) {
       if ($.inArray(pathname,value) !== -1) {
           $('.nav-list a[href="' + key + '"]').parent().addClass('active');
           $(".nav-list a[href='" + key + "']").parent().parents('li').addClass('active open');
       }
    });
});
