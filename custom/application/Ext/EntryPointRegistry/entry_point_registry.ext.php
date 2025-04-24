<?php 
 //WARNING: The contents of this file are auto-generated


// Register the entry point
$entry_point_registry['LeadFormEntryPoint'] = array(
    'file' => 'custom/LeadFormEntryPoint.php',
    'auth' => false,
);



  $entry_point_registry['MyTimeEntryPoint'] = array(
      'file' => 'custom/MyTimeEntryPoint.php',
      'auth' => true,
  );

  if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
$date = new DateTime();
// echo $date->format('r');
?>