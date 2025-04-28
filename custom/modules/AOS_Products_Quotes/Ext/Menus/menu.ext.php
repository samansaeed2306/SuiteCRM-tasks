<?php 
 //WARNING: The contents of this file are auto-generated


global $mod_strings, $app_strings, $sugar_config;

if (ACLController::checkAccess('AOS_Products_Quotes', 'edit', true)) {
    $module_menu[] = array(
        "index.php?module=AOS_Products_Quotes&action=EditView&return_module=AOS_Products_Quotes&return_action=DetailView",
        $mod_strings['LNK_NEW_RECORD'], // You can define custom label
        "Create",
        'AOS_Products_Quotes'
    );
}

if (ACLController::checkAccess('AOS_Products_Quotes', 'list', true)) {
    $module_menu[] = array(
        "index.php?module=AOS_Products_Quotes&action=index&return_module=AOS_Products_Quotes&return_action=DetailView",
        $mod_strings['LNK_RECORD_LIST'], // You can define custom label
        "List",
        'AOS_Products_Quotes'
    );
}

if (ACLController::checkAccess('AOS_Products_Quotes', 'import', true)) {
    $module_menu[] = array(
        "index.php?module=Import&action=Step1&import_module=AOS_Products_Quotes&return_module=AOS_Products_Quotes&return_action=index",
        $mod_strings['LNK_IMPORT_AOS_PRODUCTS_QUOTES'],
        "Import",
        'AOS_Products_Quotes'
    );
}


?>