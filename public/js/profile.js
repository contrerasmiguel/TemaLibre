$(document).ready(function () {
    $('#recentCommentsButton').click(function() {
        $('#topicsSubscribed').hide();
        $('#recentComments').show();
    });
    $('#topicsSubscribedButton').click(function () {
        $('#recentComments').hide();
        $('#topicsSubscribed').show();
    });
});