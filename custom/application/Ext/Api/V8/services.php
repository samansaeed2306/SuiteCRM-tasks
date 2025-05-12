<?php
/**
 * Created by PhpStorm.
 * User: Abuzar
 * Date: 10/23/2020
 * Time: 3:48 PM
 */

use Api\V8\BeanDecorator\BeanManager;
use Api\V8\JsonApi\Helper\AttributeObjectHelper;
use Api\V8\JsonApi\Helper\PaginationObjectHelper;
use Api\V8\JsonApi\Helper\RelationshipObjectHelper;
use Api\V8\Service;
use Psr\Container\ContainerInterface as Container;

return [Service\CustomModuleService::class => function (Container $container) {
    return new Service\CustomModuleService(
        $container->get(BeanManager::class),
        $container->get(AttributeObjectHelper::class),
        $container->get(RelationshipObjectHelper::class),
        $container->get(PaginationObjectHelper::class)
    );
}];