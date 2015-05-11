$(document).ready(function() {
    $('.request-header').on('click', function () {
        $requestSumup   = $(this).find('.request-sumup');
        $requestContent = $(this).siblings('.request-content');

        if ($requestContent.hasClass('hide')) {
            $requestContent.removeClass('hide').addClass('active');
            $requestSumup.removeClass('active').addClass('hide');
        } else {
            $requestContent.removeClass('active').addClass('hide');
            $requestSumup.removeClass('hide').addClass('active');
        }
    });
});
