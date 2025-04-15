<?php 
 //WARNING: The contents of this file are auto-generated


$dictionary['Lead']['fields']['account_name'] = array(
    'name' => 'account_name',
    'vname' => 'LBL_ACCOUNT_NAME',
    'type' => 'varchar',
    'len' => 255,
    'required' => true,
    'audited' => true,
    'massupdate' => true,
    'duplicate_merge' => 'enabled',
    'merge_filter' => 'enabled',
    'calculated' => false,
    'size' => '20',
    'enable_range_search' => false,
    'importable' => 'required',
    'duplicate_merge_dom_value' => '1',
    'studio' => 'visible',
    'reportable' => true,
    'default' => '',
   
);




$dictionary['Lead']['fields']['existing_c'] = array(
    'name' => 'existing_c',
    'vname' => 'LBL_EXISTING',
    'type' => 'bool',
    'default' => 0,
    'source' => 'custom_fields',  // Ensures it is placed in the cstm table
    'required' => false,
    'audited' => true,
    'reportable' => true,
    'unified_search' => false,
    'importable' => true,
);

$dictionary['Lead']['fields']['user_remarks_c'] = array(
    'name' => 'user_remarks_c',
    'vname' => 'LBL_USER_REMARKS',
    'type' => 'varchar',
    'len' => 255,
    'source' => 'custom_fields',  // Ensures it is placed in the cstm table
    'required' => false,
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'importable' => true,
);


 // created: 2025-04-15 09:10:21
$dictionary['Lead']['fields']['jjwg_maps_address_c']['inline_edit']=1;

 

 // created: 2025-04-15 09:10:21
$dictionary['Lead']['fields']['jjwg_maps_geocode_status_c']['inline_edit']=1;

 

 // created: 2025-04-15 09:10:21
$dictionary['Lead']['fields']['jjwg_maps_lat_c']['inline_edit']=1;

 

 // created: 2025-04-15 09:10:21
$dictionary['Lead']['fields']['jjwg_maps_lng_c']['inline_edit']=1;

 
?>