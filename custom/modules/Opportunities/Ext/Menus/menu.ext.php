<?php 
 //WARNING: The contents of this file are auto-generated

 


if (ACLController::checkAccess('Opportunities', 'list', true)) { 
    $module_menu[] = array(
        "index.php?module=Opportunities&action=CustomOpportunities", 
        'View Closed Won Opportunities', 
        'Opportunities'
    );
    // Uncomment if you want to add a menu item for lost opportunities
    $module_menu[] = array(
        "index.php?module=Opportunities&action=LostOpportunities", 
        'Lost Opportunities', 
        'Opportunities'
    );
}
?>