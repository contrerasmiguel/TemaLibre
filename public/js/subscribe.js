$(document).ready(function () {
    var topicId = $('#topicIdInput').val();
    var userId = $('#userIdInput').val();

    $('#subscribeButton').click(function () {
        if ($(this).hasClass('btn-subscribe')) {
            $.ajax({
                  type: 'POST'
                , url: '/subscriptions/create'
                , data: { topicId: topicId, userId: userId }
                , dataType: 'JSON'
                , error: function (data) {
                }
                , success: function (data) {
                }
            });

            $(this)
                .removeClass('btn-subscribe btn-success')
                .addClass('btn-unsubscribe btn-danger')
                .html('Dejar de seguir');
        }
        else {
            $.ajax({
                type: 'POST'
                , url: '/subscriptions/remove'
                , data: { topicId: topicId, userId: userId }
                , dataType: 'JSON'
                , error: function (data) {
                }
                , success: function (data) {
                }
            });

            $(this)
                .removeClass('btn-unsubscribe btn-danger')
                .addClass('btn-subscribe btn-success')
                .html('Seguir');
        }
    });
});