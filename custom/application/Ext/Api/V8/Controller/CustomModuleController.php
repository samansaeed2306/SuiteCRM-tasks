<?php


namespace Api\V8\Controller;

use Api\V8\Service;
use Slim\Http\Request;
use Slim\Http\Response;

require_once 'custom/application/Ext/Api/V8/Service/CustomModuleService.php';

class CustomModuleController extends ModuleController
{
    protected $moduleService;

    public function __construct(Service\CustomModuleService $moduleService)
    {
        // parent::__construct($moduleService); // call parent constructor
        $this->moduleService = $moduleService; // optional if already assigned by parent
    }

    /**
     * Get quote with line items
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function getWonOpportunities(Request $request, Response $response, array $args)
{
    try {
        $data = $this->moduleService->getWonOpportunities();
        return $response->withJson($data, 200);
    } catch (\Exception $exception) {
        return $this->generateErrorResponse($response, $exception, 500);
    }
}
public function getActiveAccounts(Request $request, Response $response, array $args)
{
    try {
        $responseData = $this->moduleService->getActiveAccounts();
        return $response->withJson($responseData, 200);
    } catch (\Exception $exception) {
        return $this->generateErrorResponse($response, $exception, 400);
    }
}
    // public function getMetqQuoteWithLineItems(Request $request, Response $response, array $args)
    // {
    //     try {
    //         $quoteId = $args['id'] ?? '';

    //         if (empty($quoteId)) {
    //             return $response->withJson(['error' => 'Quote ID is required'], 400);
    //         }

    //         $responseData = $this->moduleService->getMetqQuoteWithLineItems($quoteId);
    //         return $response->withJson($responseData, 200);
    //     } catch (\Exception $exception) {
    //         return $this->generateErrorResponse($response, $exception, 400);
    //     }
    // }
}