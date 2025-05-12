<?php
use Api\V8\Param;
use Api\V8\Factory\ParamsMiddlewareFactory;
use Psr\Container\ContainerInterface as Container;
use Api\V8\BeanDecorator\BeanManager;
use Api\V8\JsonApi\Repository\Filter as FilterRepository;
use Api\V8\JsonApi\Repository\Sort as SortRepository;

$paramsMiddlewareFactory = $app->getContainer()->get(ParamsMiddlewareFactory::class);

$app->get('/accounts', function() {
    global  $app;
    $container= $app->getContainer();
    $beanManager=$container->get(BeanManager::class);
    $beanArray=[];
    $offset=0;
    $increment=2000;
    while (true) {
        $offset+=$increment;
        $beanListResponse = $beanManager->getList('Accounts')
            ->deleted('0')
            ->offset($offset)
            ->limit($increment)
            ->max($increment)
            ->fields(['id', 'name', 'website', 'industry','billing_address_postalcode'])
            ->fetch();
        $beans = $beanListResponse->getBeans();
        foreach ($beans as $bean) {
            $bean_data = [];
            $bean_data[] = $bean->id;
            $bean_data[] = $bean->name;
            $bean_data[] = $bean->website;
            $bean_data[] = $bean->industry;
            $bean_data[] = $bean->billing_address_postalcode;
            $beanArray[] = $bean_data;
        }
        if (count($beans) == 0) {
            break;
        }
    }

    $arr1=array();
    $arr1["Hello"]='Hello World!';
    $arr1["data"]=$beanArray;
    return json_encode($arr1);
});
$app->get('/module/{moduleName}', 'Api\V8\Controller\CustomModuleController:getModuleRecords')
    ->add($paramsMiddlewareFactory->bind(Param\GetModulesParams::class));
$app->get('/module/{moduleName}/{id}', 'Api\V8\Controller\CustomModuleController:getModuleRecord')
    ->add($paramsMiddlewareFactory->bind(Param\GetModuleParams::class));
$app->get('/leader_board', function($request) {
    //global $Data
    $beanmanager=$this->get(BeanManager::class);
    $oauth2Token = $beanmanager->newBeanSafe('OAuth2Tokens');

    $oauth2Token->retrieve_by_string_fields(
        ['access_token' => $request->getAttribute('oauth_access_token_id')]
    );

    $current_user=$currentUser = $beanmanager->getBeanSafe('Users', $oauth2Token->assigned_user_id);

    global $timedate;
    $timedate->setUser($current_user);
    $response=array();
    $db = DBManagerFactory::getInstance();
    if(empty($_REQUEST["status"])||empty($_REQUEST["timeframe"])){
        return json_encode($response);
    }
    $format=$timedate->get_db_date_format();
    $user_format=$timedate->get_date_time_format($current_user);
    //to_db
    //get_date_time_format
    $timeframe=$_REQUEST["timeframe"];
    $status=$_REQUEST["status"];
    $strt=$_REQUEST["start"];
    $endd=$_REQUEST["end"];
    $start='';
    $end='';
    $start=strtotime("today");

    $start=$timedate->getNow(false);
    $start_date=date_time_set($start,0,0,0,0);
    switch ($timeframe){
        case 'Today':

            $start=date_timestamp_get($start_date);
            $end=date_timestamp_get(date_add(clone $start_date,date_interval_create_from_date_string('1 days')));
            break;
        case 'Yesterday':
            $end=date_timestamp_get($start_date);
            $start=date_timestamp_get(date_sub(clone $start_date,date_interval_create_from_date_string('1 days')));
            break;
        case 'This Week':
            $day = intval(date_format($start_date,'w'));
            $start_dte=date_sub(clone $start_date,date_interval_create_from_date_string($day.' days'));
            $start=date_timestamp_get($start_dte);
            $end=date_timestamp_get(date_add(clone $start_dte,date_interval_create_from_date_string('7 days')));

            break;
        case 'Last Week':
            $day = intval(date_format($start_date,'w'));
            $start_dte=date_sub(clone $start_date,date_interval_create_from_date_string($day.' days'));
            $end=date_timestamp_get($start_dte);
            $start=date_timestamp_get(date_sub(clone $start_dte,date_interval_create_from_date_string('7 days')));

            break;
        case 'This Month':
            $day = intval(date_format($start_date,'d'))-1;
            $start_dte=date_sub(clone $start_date,date_interval_create_from_date_string($day.' days'));
            $start=date_timestamp_get($start_dte);
            $end=date_timestamp_get(date_add(clone $start_dte,date_interval_create_from_date_string('1 month')));

            break;
        case 'Last Month':
            $day = intval(date_format($start_date,'d'))-1;
            $start_dte=date_sub(clone $start_date,date_interval_create_from_date_string($day.' days'));
            $end=date_timestamp_get($start_dte);
            $start=date_timestamp_get(date_sub(clone $start_dte,date_interval_create_from_date_string('1 month')));

            break;
        case 'This Year':
            $day = intval(date_format($start_date,'z'));
            $start_dte=date_sub(clone $start_date,date_interval_create_from_date_string($day.' days'));
            $start=date_timestamp_get($start_dte);
            $end=date_timestamp_get(date_add(clone $start_dte,date_interval_create_from_date_string('1 year')));

            break;
        case 'Last Year':
            $day = intval(date_format($start_date,'z'));
            $start_dte=date_sub(clone $start_date,date_interval_create_from_date_string($day.' days'));
            $end=date_timestamp_get($start_dte);
            $start=date_timestamp_get(date_sub(clone $start_dte,date_interval_create_from_date_string('1 year')));

            break;
        case 'Custom':
            $start=$timedate->getNow(false);
            $start_date=date_time_set($start,0,0,0,0);
            $start=date_timestamp_get(date_date_set($start_date,explode("-",$strt)[2],explode("-",$strt)[1],explode("-",$strt)[0]));

            $end=$timedate->getNow(false);
            $end=date_time_set($end,0,0,0,0);
            $end=date_timestamp_get(date_date_set($end,explode("-",$endd)[2],explode("-",$endd)[1],explode("-",$endd)[0]));

            break;



        default:
            $start=strtotime("today");
            $end=strtotime("tomorrow");
            break;
    }
    $start=date($user_format,$start);
    $end=date($user_format,$end);
    $start=$timedate->to_db($start);
    $end=$timedate->to_db($end);
    $start=$db->quote($start);
    $end=$db->quote($end);
    $status=$db->quote($status);
    if($status!='SIPLead'){
        $query="
   select assigned_user_id,count(*) as lead_count
from ( select id,assigned_user_id from
(SELECT leads_audit.parent_id as id,leads_audit.date_created,leads.created_by as assigned_user_id ,after_value_string as status,'first' as tab FROM leads_audit
join leads on leads_audit.parent_id=leads.id
where field_name='status' and after_value_string='$status' and leads.lead_source='SIP' and leads.deleted='0'
union
select id,date_entered as date_created,created_by as assigned_user_id,status,'second' as tab from leads
where status='$status' and leads.deleted='0' and leads.lead_source='SIP'
union
SELECT parent_id as id,leads.date_entered as date_created,leads.created_by as assigned_user_id ,before_value_string as status ,'third' as tab FROM leads_audit
join leads on leads_audit.parent_id=leads.id
where field_name='status' and before_value_string='$status' and leads.deleted='0' and leads.lead_source='SIP'
) abc
where abc.date_created>='$start' and abc.date_created<'$end'
group by id,assigned_user_id) abc1
group by assigned_user_id ";
    }
    else{
        $query="
   select assigned_user_id,count(*) as lead_count
from ( select id,assigned_user_id from
(
select id,date_entered as date_created,created_by as assigned_user_id,status,'second' as tab from leads
where status='$status' and leads.deleted='0' and leads.lead_source='SIP'
union
SELECT parent_id as id,leads.date_entered as date_created,leads.created_by as assigned_user_id ,before_value_string as status ,'third' as tab FROM leads_audit
join leads on leads_audit.parent_id=leads.id
where field_name='status' and before_value_string='$status' and leads.deleted='0' and leads.lead_source='SIP'
) abc
where abc.date_created>='$start' and abc.date_created<'$end'
group by id,assigned_user_id) abc1
group by assigned_user_id ";
    }

    $result=$db->query($query);
    while($row=$db->fetchByAssoc($result)){
        array_push($response,$row);
    }
    return json_encode($response);
});
$app->get('/current-user', function($request) {
    //global $Data
    $beanmanager=$this->get(BeanManager::class);
    $oauth2Token = $beanmanager->newBeanSafe('OAuth2Tokens');

    $oauth2Token->retrieve_by_string_fields(
        ['access_token' => $request->getAttribute('oauth_access_token_id')]
    );

    $current_user = $beanmanager->getBeanSafe('Users', $oauth2Token->assigned_user_id);
    include 'modules/ACLActions/ACLAction.php';
    $categories=ACLAction::getUserActions($current_user->id, true);
    $names = ACLAction::setupCategoriesMatrix($categories);
    $current=$current_user->toArray();
    $current["permissions"]=$categories;
    unset($current["user_hash"]);
    $response=array();
    $response["data"]=array("type"=>"User","id"=>$current_user->id,"attributes"=>$current);
    return json_encode($response);


});
$app->get('/get-data', function($request) {
    //global $Data
    $beanmanager=$this->get(BeanManager::class);
    $oauth2Token = $beanmanager->newBeanSafe('OAuth2Tokens');

    $oauth2Token->retrieve_by_string_fields(
        ['access_token' => $request->getAttribute('oauth_access_token_id')]
    );

    $current_user = $beanmanager->getBeanSafe('Users', $oauth2Token->assigned_user_id);
    include 'modules/ACLActions/ACLAction.php';
    $categories=ACLAction::getUserActions($current_user->id, true);
    $names = ACLAction::setupCategoriesMatrix($categories);
    $current=$current_user->toArray();
    $current["permissions"]=$categories;
    unset($current["user_hash"]);
    $response=array();
    $response["data"]=array("type"=>"User","id"=>$current_user->id,"attributes"=>$current);



    global  $app;
    $container= $app->getContainer();
    $beanManager=$container->get(BeanManager::class);
    $beanArray=[];
    $offset=0;
    $increment=5000;
    while (true) {
        $beanListResponse = $beanManager->getList('Accounts')
            ->deleted('0')
            ->offset($offset)
            ->limit($increment)
            ->max($increment)
            ->fields(['id', 'name', 'website', 'industry','billing_address_postalcode'])
            ->fetch();
        $offset+=$increment;

        $beans = $beanListResponse->getBeans();
        foreach ($beans as $bean) {
            $bean_data = [];
            $bean_data[] = $bean->id;
            $bean_data[] = $bean->name;
            $bean_data[] = $bean->website;
            $bean_data[] = $bean->industry;
            $bean_data[] = $bean->billing_address_postalcode;
            $beanArray[] = $bean_data;
        }
        if (count($beans) == 0) {
            break;
        }
    }


    $response["data_accounts"]=$beanArray;
    $beanManager=$container->get(BeanManager::class);

    $beanArray=[];
    $bean_usr = $beanManager->newBeanSafe(
        'Users'
    );
    $fields = $beanManager->getDefaultFields($bean_usr);
    $fields=$beanManager->filterAcceptanceFields($bean_usr, $fields);
    $offset=0;
    $increment=2000;
    while (true) {
        $beanListResponse = $beanManager->getList('Users')

            ->deleted('0')
            ->fields($fields)
            ->limit($increment)
            ->fetch();

        $beans = $beanListResponse->getBeans();
        foreach ($beans as $bean) {
            $bean_data= $bean->toArray();
            unset($bean_data["user_hash"]);
            $beanArray[] = array("type"=>"User","id"=>$bean->id,"attributes"=>$bean_data);
        }
        break;
    }
    $response["data_users"]=$beanArray;

    $lead_fields=buildFieldList("Leads",$beanManager);
    $response["data_leads"]=array("type"=>"Meta","attributes"=>$lead_fields);

    return json_encode($response);


});
$app->get('/get-notes', function($request) {
    //global $Data
    $response=[];
    if(!isset($_REQUEST['lead_id'])){
        $response['data']=[];
        return json_encode($response);
    }
    $lead_id=$_REQUEST['lead_id'];

    global  $app;
    $container= $app->getContainer();

    $beanManager=$container->get(BeanManager::class);

    $beanArray=[];
    $bean_usr = $beanManager->newBeanSafe(
        'Notes'
    );
    $fields = $beanManager->getDefaultFields($bean_usr);
    $fields=$beanManager->filterAcceptanceFields($bean_usr, $fields);
    $offset=0;
    $increment=2000;
    while (true) {
        $beanListResponse = $beanManager->getList('Notes')
            ->where("parent_type='Leads' AND parent_id='$lead_id'")
            ->deleted('0')
            ->orderBy('date_entered desc')
            ->fields($fields)
            ->limit($increment)
            ->fetch();

        $beans = $beanListResponse->getBeans();
        foreach ($beans as $bean) {
            $bean_data= $bean->toArray();
            if(strpos( $bean_data["file_mime_type"],'image')!==false){
                $bean_data["file_url"]="?entryPoint=download&type=Notes&id={$bean_data["id"]}&preview=yes";

            }
            else{
                $bean_data["file_url"]="?entryPoint=download&type=Notes&id={$bean_data["id"]}";

            }
            unset($bean_data["user_hash"]);
            $beanArray[] = array("type"=>"Note","id"=>$bean->id,"attributes"=>$bean_data);
        }
        break;
    }
    $response["data"]=$beanArray;


    return json_encode($response);


});
$app->get('/get-leads', function($request) {
    //global $Data
    $response=[];
    global  $app;
    $container= $app->getContainer();

    $beanManager=$container->get(BeanManager::class);
    $bean = $beanManager->newBeanSafe(
        'Leads'
    );
    $sort = new SortRepository();
    $orderBy=$sort->parseOrderBy($bean, $_REQUEST["sort"]);
    $filter = new FilterRepository($bean->db);
    $where=$filter->parseWhere($bean, isset($_REQUEST["filter"])?$_REQUEST["filter"]:array());
    $fields = $_REQUEST["fields"]["Lead"];




    $beanArray=[];
    if(empty($fields)){
        $fields = $beanManager->getDefaultFields($bean);
    }
    else{
        $fields=explode(',',$fields);
        $fields=$beanManager->filterAcceptanceFields($bean, $fields);

    }
    $offset=0;
    $increment=3000;
    while (true) {
        $beanListResponse = $beanManager->getList('Leads')
            ->where($where)
            ->deleted('0')
            ->orderBy($orderBy)
            ->fields($fields)
            ->offset($offset)
            ->limit($increment)
            ->max($increment)
            ->fetch();
        $offset+=$increment;

        $beans = $beanListResponse->getBeans();
        foreach ($beans as $bean) {
            $bean_data= getAttributes($bean,$fields);

            $beanArray[] = array("type"=>"Lead","id"=>$bean->id,"attributes"=>$bean_data);
        }
        if (count($beans) == 0) {
            break;
        }
    }
    $response["data"]=$beanArray;


    return json_encode($response);


});

function buildFieldList($module,$beanManager)
{
    include_once ('include/utils.php');
    //$this->checkIfUserHasModuleAccess($module);
    $bean = $beanManager->newBeanSafe($module);
    global $app_list_strings;
    global $mod_strings;

    $fieldList = [];
    foreach ($bean->field_defs as $fieldName => $fieldDef) {
        $fieldList[$fieldName] = pruneVardef($fieldDef);
        if(isset($fieldList[$fieldName]['vname'])){
            $fieldList[$fieldName]['vname']=translate($fieldList[$fieldName]['vname'],$module);
        }
    }

    return $fieldList;
}
function pruneVardef($def)
{
    global $app_list_strings;

    $allowedVardefFields = [
        'type',
        'dbType',
        'source',
        'relationship',
        'default',
        'len',
        'precision',
        'comments',
        'required',
        'vname',
    ];
    $pruned = [];
    foreach ($def as $var => $val) {
        if (in_array($var, $allowedVardefFields, true)) {
            $pruned[$var] = $val;
        }
    }
    if (!isset($def['required'])) {
        $pruned['required'] = false;
    }
    if (!isset($def['dbType'])) {
        $pruned['dbType'] = $def['type'];
    }
    if(isset($pruned['type'])&&$pruned['type']=='enum'){
        $pruned['options']=$app_list_strings[$def['options']];
    }

    return $pruned;
}
function getAttributes(\SugarBean $bean, $fields = null)
{
    $bean->fixUpFormatting();

    // using the ISO 8601 format for dates
    $attributes = array_map(function ($value) {
        return is_string($value)
            ? (\DateTime::createFromFormat('Y-m-d H:i:s', $value)
                ? date(\DateTime::ATOM, strtotime($value))
                : $value)
            : $value;
    }, $bean->toArray());

    if ($fields !== null) {
        $attributes = array_intersect_key($attributes, array_flip($fields));
    }

    unset($attributes['id']);

    return $attributes;
}

/*
 leaderboard query
 select * from
(SELECT parent_id as id,date_created,created_by ,after_value_string as status,'first' as tab FROM leads_audit
where field_name='status' and after_value_string='New'
union
select id,date_entered as date_created,created_by,status,'second' as tab from leads
where status="New"
union
SELECT parent_id as id,leads.date_entered as date_created,leads_audit.created_by ,before_value_string as status ,'third' as tab FROM leads_audit
join leads on leads_audit.parent_id=leads.id
where field_name='status' and before_value_string='New' ) abc
where abc.date_created>'2020-10-15'


%% with assigned user
select * from
(SELECT leads_audit.parent_id as id,leads_audit.date_created,leads.assigned_user_id ,after_value_string as status,'first' as tab FROM leads_audit
join leads on leads_audit.parent_id=leads.id
where field_name='status' and after_value_string='New'
union
select id,date_entered as date_created,assigned_user_id,status,'second' as tab from leads
where status="New"
union
SELECT parent_id as id,leads.date_entered as date_created,leads.assigned_user_id ,before_value_string as status ,'third' as tab FROM leads_audit
join leads on leads_audit.parent_id=leads.id
where field_name='status' and before_value_string='New' ) abc
where abc.date_created>'2020-10-15'
group by id,assigned_user_id

  */
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