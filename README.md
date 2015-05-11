Request Collector Bundle
------------------------

The request collector bundle collects HTTP requests from various internet services (webhooks, api) or local calls.  
It exposes an URL that will persist, log and mail the incomming requests.  
You can choose how to collect requests in the configuration by enabling or disabling persisting, logging or mailling.  
The collected HTTP requests contain headers, query string parameters , post/form parameters and the body / content of the request.

It will help you to inspect or debug webhooks / api requests.  

You can also add a your own custom service which will be executed just after the collect process by tagging a Symfony service from your application (CF Extension).

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
    resource: .
    type: request_collector
```

*app/config/config.yml*
```yaml
deuzu_request_collector:
    collectors:
        default:
            route_path: /request-collector/collect
```
*You need to configure one collector and its route_path. By default the collector only persists the request.*

*Create Doctrine schema if needed*
```bash
$ php app/console doctrine:database:create
$ php app/console doctrine:schema:create
```

*...or update it*

```bash
$ php app/console doctrine:schema:update --force
```

*You're done. To test it try to access a configured URL and then add /inspect at the end to see the persisted requests. Logs are located in app/logs/ and named by default request_collector.log*

## Configuration

*app/config/config.yml*
```yaml
deuzu_request_collector:
    assets:
        bootstrap3_css: true # or bundles/your_app/css/bootstrap.min.css
        bootstrap3_js: true  # or bundles/your_app/js/bootstrap.min.js
        jquery: true         # or bundles/your_app/js/jquery.min.js
    collectors:
        default:
            route_path: /what/ever/you/want
        github:
            route_path: /github/webhook
            log:
                enabled: true
                file: github_collector.log # app/logs/github_collector.log
            mail:
                enabled: true
                email: florian.touya@gmail.com
            persist:
                enabled: true
```

*If you want to use jQuery and Bootstrap3 packaged in the bundle instead of yours add the bundle to Assetic :*
*app/config/config.yml*
```yaml
assetic:
    bundles: [ DeuzuRequestCollectorBundle ]
```

*Then install assets*
```bash
$ php app/console assets:install --symlink web/
```

## Extension

*Events are propagated before and after each collect (mail, log and persist).*
*The list of available events is in the class `Deuzu\RequestCollectorBundle\Event\Events`.*

*If you want to add your own custom service after the collect process all you have to do is to tag it like this :*
```yaml
post_collect_handler.default:
    class: AppBundle\Service\CustomPostCollectHandler
    tags:
        - { name: post_collect_handler }
```


## TODO
   * Better doc
   * Improve templates
      * toggle with title
      * copy full URL (+ cURL ?)
      * improve colors badge and labels
   * fix display for array in query string
