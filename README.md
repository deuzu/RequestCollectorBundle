Request Collector Bundle
------------------------

[![Build Status](https://travis-ci.org/deuzu/RequestCollectorBundle.svg?branch=master)](https://travis-ci.org/deuzu/RequestCollectorBundle)
[![Latest Stable Version](https://poser.pugx.org/deuzu/request-collector-bundle/v/stable)](https://packagist.org/packages/deuzu/request-collector-bundle) [![Total Downloads](https://poser.pugx.org/deuzu/request-collector-bundle/downloads)](https://packagist.org/packages/deuzu/request-collector-bundle) [![Latest Unstable Version](https://poser.pugx.org/deuzu/request-collector-bundle/v/unstable)](https://packagist.org/packages/deuzu/request-collector-bundle) [![License](https://poser.pugx.org/deuzu/request-collector-bundle/license)](https://packagist.org/packages/deuzu/request-collector-bundle)

The request collector Symfony bundle collects HTTP requests from various internet services (webhooks, api) or local calls.
It exposes an URL that will persist, log and / or mail the incomming requests.
The collected HTTP requests contain headers, query string parameters , post/form parameters and the body / content of the request.

It will help you to inspect, debug or process webhooks / api requests.

You can also add a your own custom service which will be executed just after the collect process by tagging a Symfony service from your application (CF Extension).


## Installation

```bash
composer require deuzu/request-collector-bundle
```

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
framework:
    # ...
    serializer: { enable_annotations: true }

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

*You're done. To test it try to access a configured URL and then add /inspect at the end to see the persisted requests. Logs are located in the log folder and named by default request_collector.log*


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
            logger:
                enabled: true
                channel: github
            mailer:
                enabled: true
                email: florian.touya@gmail.com
            persister:
                enabled: true
```

If you are using a different channel, add it to monolog configuration

*app/config/config.yml*

```yaml
monolog:
    channels: ['github']
    handlers:
        # ...
        github:
            type: stream
            path: '%kernel.logs_dir%/%kernel.environment%.github.log'
            level: debug
            channels: [github]
```


## Extension

*If you want to add your own custom service after the collect process all you have to do is to tag it like this :*
```yaml
post_collect_handler.default:
    class: AppBundle\Service\CustomPostCollectHandler
    tags:
        - { name: request_collector.post_collect_handler, alias: collector_name }
```
*Your custom service must implements Deuzu\RequestCollectorBundle\PostCollectHandler\PostCollectHandlerInterface*


## TODO
   * contributing.md, pr_template.md
   * Menu with differents collectors
      * button to copy address which collects
      * Inspect all collector action
   * Improve templates
      * filters
   * Add translations (en only)
