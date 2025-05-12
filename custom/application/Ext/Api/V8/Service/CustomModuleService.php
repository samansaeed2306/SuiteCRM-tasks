<?php

namespace Api\V8\Service;

use Api\V8\BeanDecorator\BeanManager;
use Api\V8\JsonApi\Helper\AttributeObjectHelper;
use Api\V8\JsonApi\Helper\RelationshipObjectHelper;
use BeanFactory;
use Exception;

#[\AllowDynamicProperties]
class CustomModuleService extends ModuleService
{
    /**
     * @var BeanManager
     */
    protected $beanManager;

    /**
     * @var AttributeObjectHelper
     */
    protected $attributeHelper;

    /**
     * @var RelationshipObjectHelper
     */
    protected $relationshipHelper;

    /**
     * QuotesService constructor.
     *
     * @param BeanManager $beanManager
     * @param AttributeObjectHelper $attributeHelper
     * @param RelationshipObjectHelper $relationshipHelper
     */
    public function __construct(
        BeanManager              $beanManager,
        AttributeObjectHelper    $attributeHelper,
        RelationshipObjectHelper $relationshipHelper
    )
    {
        $this->beanManager = $beanManager;
        $this->attributeHelper = $attributeHelper;
        $this->relationshipHelper = $relationshipHelper;
    }

    /**
     * Get quote with line items
     *
     * @param string $quoteId
     * @return array
     * @throws Exception
     */
    public function getWonOpportunities()
{
    $opportunities = BeanFactory::getBean('Opportunities');
    $query = "opportunities.sales_stage = 'Closed Won' AND opportunities.deleted = 0";

    $results = $opportunities->get_full_list(
        $order_by = "date_closed DESC",
        $where = $query
    );

    $data = [];

    foreach ($results as $opp) {
        $data[] = [
            'id' => $opp->id,
            'name' => $opp->name,
            'amount' => $opp->amount,
            'date_closed' => $opp->date_closed,
            'account_id' => $opp->account_id,
            'assigned_user_id' => $opp->assigned_user_id,
            'sales_stage' => $opp->sales_stage,
        ];
    }

    return $data;
}

// public function getActiveAccounts()
// {
//     $accounts = BeanFactory::getBean('Accounts');
//     $query = $accounts->get_full_list(
//         '', // No limit
//         "accounts.deleted = 0 AND accounts.account_status = 'Active'"
//     );

//     $activeAccounts = [];

//     if (!empty($query)) {
//         foreach ($query as $account) {l
//             $activeAccounts[] = [
//                 'id' => $account->id,
//                 'name' => $account->name,
//                 'industry' => $account->industry,
//                 'phone_office' => $account->phone_office,
//                 'billing_address_city' => $account->billing_address_city,
//                 'account_status' => $account->account_status,
//             ];
//         }
//     }

//     return $activeAccounts;
// }
public function getActiveAccounts()
{
    global $db;

    $sql = "
        SELECT 
            a.id, a.name, a.industry, a.phone_office, a.billing_address_city, ac.account_status
        FROM 
            accounts a
        LEFT JOIN 
            accounts_cstm ac ON a.id = ac.id_c
        WHERE 
            a.deleted = 0 AND ac.account_status = 'Active'
    ";

    $result = $db->query($sql);
    $activeAccounts = [];

    while ($row = $db->fetchByAssoc($result)) {
        $activeAccounts[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'industry' => $row['industry'],
            'phone_office' => $row['phone_office'],
            'billing_address_city' => $row['billing_address_city'],
            'account_status' => $row['account_status'],
        ];
    }

    return $activeAccounts;
}

}