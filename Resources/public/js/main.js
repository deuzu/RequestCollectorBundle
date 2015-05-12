$(document).ready(function() {
    $('.tab a').on('click', function(e) {
        console.log('dsaddsa');
        e.preventDefault();
        $(this).tab('show');
    });

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
