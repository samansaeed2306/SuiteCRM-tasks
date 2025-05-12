<?php
use Api\V8\Param;
use Api\V8\Factory\ParamsMiddlewareFactory;
use Psr\Container\ContainerInterface as Container;
use Api\V8\BeanDecorator\BeanManager;
use Api\V8\JsonApi\Repository\Filter as FilterRepository;
use Api\V8\JsonApi\Repository\Sort as SortRepository;

$paramsMiddlewareFactory = $app->getContainer()->get(ParamsMiddlewareFactory::class);
$dirPath = __DIR__;
if (is_dir($dirPath) && $dh = opendir($dirPath)) {
    while (($file = readdir($dh)) !== false) {
        if ($file === '.' || $file === '..' || $file === 'routes.php') {
            continue;
        }
        if (preg_match('/^custom_routes.*\.php$/', $file)) {
            include_once $dirPath . '/' . $file;
        }
    }
    closedir($dh);
}