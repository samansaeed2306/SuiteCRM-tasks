<?php 
 //WARNING: The contents of this file are auto-generated


  $entry_point_registry['MyTimeEntryPoint'] = array(
      'file' => 'custom/MyTimeEntryPoint.php',
      'auth' => true,
  );

  if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
$date = new DateTime();
echo $date->format('r');
?>