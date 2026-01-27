$(document).on('click', '.add-to-favorite', function() {

    let btn = $(this);
    let projectId = btn.data('project');

    $.ajax({
        url: window.favoritesToggleUrl, // استخدم الرابط من Blade
        method: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'), // استخدم meta
            project_id: projectId
        },
        success: function(res) {
            if (res.status === 'added') {
                btn.removeClass('btn-outline-primary')
                    .addClass('btn-danger');
            } else {
                btn.removeClass('btn-danger')
                    .addClass('btn-outline-primary');
            }
        },
        error: function(err) {
            console.error(err);
        }
    });

});
