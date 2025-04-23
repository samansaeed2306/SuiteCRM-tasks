<?php
  $entry_point_registry['MyTimeEntryPoint'] = array(
      'file' => 'custom/MyTimeEntryPoint.php',
      'auth' => true,
  );

  if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
$date = new DateTime();
echo $date->format('r');