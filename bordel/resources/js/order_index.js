$(document).ready(function () {
    $('.toggle-btn').click(function () {
        var target = $(this).data('target');
        $('.toggle-btn').removeClass('active');
        $(this).addClass('active');
        $('.order-block').hide();
        $('#' + target).show();
    });
});
