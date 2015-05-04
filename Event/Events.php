<?php

namespace Deuzu\Bundle\RequestCollectorBundle\Event;

final class Events
{
    /** PRE_PERSIST event occurs when a Request before its persistence  */
    const PRE_PERSIST = 'deuzu.request_collector.pre_persist';

    /** POST_PERSIST event occurs when a Request after its persistence  */
    const POST_PERSIST = 'deuzu.request_collector.post_persist';

    /** PRE_LOG event occurs when a Request before logging it */
    const PRE_LOG = 'deuzu.request_collector.pre_log';

    /** POST_LOG event occurs when a Request after logging it */
    const POST_LOG = 'deuzu.request_collector.post_log';

    /** PRE_LOG event occurs when a Request before sending a mail */
    const PRE_MAIL = 'deuzu.request_collector.pre_mail';

    /** POST_LOG event occurs when a Request after sending a mail */
    const POST_MAIL = 'deuzu.request_collector.post_mail';
}
