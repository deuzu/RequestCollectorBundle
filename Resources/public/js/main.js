$(document).ready(function() {
    $('.clipboard-copy').each(function(index, element) {
        var client = new ZeroClipboard(element);

        client.on('ready', function( readyEvent ) {
            client.on('aftercopy', function( event ) {
                $element       = $(event.target);
                $request       = $element.parents('.request');
                $alertTemplate = $('#alert-template');
                message        = $element.data('info-message');
                copiedText     = event.data['text/plain'];

                $request.prepend($alertTemplate);
                $alert = $request.find('.alert');

                $alert.find('.message').html(message);
                $alert.find('.copied-text').html(copiedText);
                $alert.removeClass('hide');
            });
        });
    });

    $('.tab a').on('click', function(e) {
        e.preventDefault();
        $(this).tab('show');
    });

    $('.request-toggle').on('click', function () {
        $requestSumup     = $(this).parent('.request-header').find('.request-sumup');
        $requestContent   = $(this).parent('.request-header').siblings('.request-content');
        $requestActiveBtn = $(this).find('.active');
        $requestHiddenBtn = $(this).find('.hide');

        $requestActiveBtn.removeClass('active').addClass('hide');
        $requestHiddenBtn.removeClass('hide').addClass('active');

        if ($requestContent.hasClass('hide')) {
            $requestContent.removeClass('hide').addClass('active');
            $requestSumup.removeClass('active').addClass('hide');
        } else {
            $requestContent.removeClass('active').addClass('hide');
            $requestSumup.removeClass('hide').addClass('active');
        }
    });
});
