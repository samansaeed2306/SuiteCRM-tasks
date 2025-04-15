<?php

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
