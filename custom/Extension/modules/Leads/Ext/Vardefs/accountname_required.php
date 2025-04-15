<?php
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

