AppKernel.php
new Deuzu\RequestCollectorBundle\DeuzuRequestCollectorBundle(),

config.yml
deuzu_request_collector:
    bootstrap3: bundles/deuzurequestcollector/css/bootstrap.min.css
    log:
        enabled: true
        file: request_collector.log
    mail:
        enabled: true
        email: florian.touya@gmail.com
    database:
        enabled: true

routing.yml
deuzu_request_collector:
    resource: "@DeuzuRequestCollectorBundle/Resources/config/routing.yml"
    prefix:   /request-collector
