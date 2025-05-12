<?php
$dictionary['Account']['fields']['account_status'] = array(
    'name' => 'account_status',
    'vname' => 'LBL_ACCOUNT_STATUS',
    'type' => 'enum',
    'options' => 'account_status_list',
    'len' => 100,
    'audited' => true,
    'required' => false,
    'massupdate' => true,
    'duplicate_merge' => 'enabled',
    'merge_filter' => 'enabled',
    'reportable' => true,
    'importable' => 'true',
    'studio' => true,
    'source' => 'custom_fields',
    'default' => 'inactive', 
);
