# Metis

> [!WARNING]
> ## Archived
> Metis is no longer maintained and will receive no further releases. It
> depends on the retired Hermes/HAL Olympus stack. For new systems, use the
> service discovery and load-balancing facilities provided by the deployment
> platform, or a maintained client designed for the target protocol.

## Introduction

This is a Dynamic Routing and Load Balance library made with PHP.

It's goal is to "choose" an endpoint to connect to in distributed systems, like in a micro service architeture.

You can use this library with [Athena](https://github.com/mt-olympus/athena) server, that can returns more than one server
and use this module to choose one of them based on some rules and statistics about the servers.

You can inject a Metis instance to a [Hermes](https://github.com/mt-olympus/hermes), and it will automatically choose a 
server to connect to. More info on the Hermes documentation. 

## Components

* Service list
* Rule

### Service list

* Static: from a configuration file
* Fetched: from a remote server

The fetched method is available through one of the following libraries:
* [metis-athena](https://github.com/mt-olympus/metis-athena): Fetches the list from a [Athena](https://github.com/mt-olympus/athena) (Service Discovery) service
* [metis-demeter](https://github.com/mt-olympus/metis-demeter): Fetches the list from a [Demeter](https://github.com/mt-olympus/demeter) (Distributed Configuration) service

#### Static server list
The list is an well formed array:
```php
return [
    'metis' => [
        'services' => [
            'service1' => [ // a unique service identification
                [
                    'host' => 'server1',
                    'uri' => 'http://192.168.1.2/v1/service1',
                ],
                [
                    'host' => 'server2',
                    'uri' => 'https://server2/v1/service1',
                ],
                [
                    'host' => 'server3',
                    'uri' => 'https://server3.mycompany.com:7001/v1/service1',
                ],
            ],
            'service2' => [ // a unique service identification
                [
                    'host' => 'server1',
                    'uri' => 'http://192.168.1.2:7002/v1/service2',
                ],
            ],
        ],
    ],
];
```

### Strategy

Regardless the chosen strategy, if there is a [Cerberus](https://github.com/mt-olympus/cerberus) (Circuit Breaker) attached,
the unavailable services will be filtered. 

* RoundRobin: Cycles among the services in a specific order
* Random: Each time will select a random service from the list
* ResponseTime: Each service has it's response time measured and this time is weighted. The faster service have more probability to be chosen.

## Installation

```
composer require mt-olympus/metis
```

### Zend Expressive

Just copy the ```config/metis.global.php.dist``` to your expressive project as config/autoload/metis.global.php

### Zend Framework

Include the module in your application.config.php
