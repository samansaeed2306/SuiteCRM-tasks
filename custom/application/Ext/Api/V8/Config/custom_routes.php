<?php
require_once 'custom/application/Ext/Api/V8/Controller/CustomModuleController.php';

// $app->get('/QuoteLineItems/{id}', 'Api\V8\Controller\CustomModuleController:getProductQuoteWithLineItems');
$app->get('/won', 'Api\V8\Controller\CustomModuleController:getWonOpportunities');
$app->get('/accounts-active', 'Api\V8\Controller\CustomModuleController:getActiveAccounts');

// $app->get('/MetQLineItems/{id}', 'Api\V8\Controller\CustomModuleController:getMetqQuoteWithLineItems');