<?php

use Api\V8\Controller;
use Api\V8\Service\CustomModuleService;
use Psr\Container\ContainerInterface as Container;

return [Controller\CustomModuleController::class => function(Container $container) {
    return new Controller\CustomModuleController(
        $container->get(CustomModuleService::class)
    );
}];