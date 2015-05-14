$(document).ready(function() {
    $('.clipboard-copy').each(function(index, element) {
        new ZeroClipboard(element);
    });

    $('.tab a').on('click', function(e) {
        e.preventDefault();
        $(this).tab('show');
    });

    $('.request-toggle').on('click', function () {
        $requestSumup   = $(this).parent('.request-header').find('.request-sumup');
        $requestContent = $(this).parent('.request-header').siblings('.request-content');

        if ($requestContent.hasClass('hide')) {
            $requestContent.removeClass('hide').addClass('active');
            $requestSumup.removeClass('active').addClass('hide');
        } else {
            $requestContent.removeClass('active').addClass('hide');
            $requestSumup.removeClass('hide').addClass('active');
        }
    });
});
