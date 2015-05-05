Request Collector Bundle
------------------------

The request collector bundle collects HTTP requests from various internet services (webhooks, api).
It exposes an URL that will persist, log and mail the incomming requests.
You can choose how to collect requests in the configuration by enabling or disabling persisting, logging or mailling.
The collected HTTP requests contain headers, query string parameters , post/form parameters and the body / content of the request.
It will help you to inspect or debug webhook / api requests.
You can also set a callback by tagging a Symfony service from your application.

## Installation

*app/AppKernel.php*
```php
$bundles = array(
    // ...
    new Deuzu\RequestCollectorBundle\DeuzuRequestCollectorBundle(),
);
```

*app/config/routing.yml*
```yaml
deuzu_request_collector:
    resource: "@DeuzuRequestCollectorBundle/Resources/config/routing.yml"
    prefix:   /request-collector
```

*All routes can be overrided like that*
```yaml
deuzu_request_collector_collect:
    path: /your-custom-path
    methods: ['GET', 'HEAD']
    defaults: { _controller: DeuzuRequestCollectorBundle:Default:collect }

```


## Configuration

*app/config/config.yml*
```yaml
deuzu_request_collector:
    bootstrap3: bundles/deuzurequestcollector/css/bootstrap.min.css
    log:
        enabled: false
        file: request_collector.log
    mail:
        enabled: false
        email: florian.touya@gmail.com
    database:
        enabled: true
```

Default value above.
All configuration is optionnal.

*If you want to use the bootstrap3 css packaged in the bundle instead of yours add the bundle to Assetic :*
*app/config/config.yml*
```yaml
assetic:
    bundles: [ DeuzuRequestCollectorBundle ]
```

*Then install assets*
```bash
$ php app/console assets:install --symlink web/
```
