<?php 
 //WARNING: The contents of this file are auto-generated


$entry_point_registry['LeadFormEntryPoint'] = array(
    'file' => 'custom/LeadFormEntryPoint.php',
    'auth' => false,
);

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once 'include/entryPoint.php';
require_once 'modules/Leads/Lead.php';

// Set content type
header('Content-Type: application/json');



// Parse incoming JSON
$input = json_decode(file_get_contents('php://input'), true);

// echo json_encode($input);



// Create Lead
$lead = new Lead();
$lead->last_name = $input['last_name'];
$lead->account_name = $input['account_name'];
$lead->first_name = $input['first_name'] ?? '';
$lead->email1 = $input['email'] ?? '';
$lead->description = $input['description'] ?? '';
$lead->status = 'New';
$lead->assigned_user_id = 1; 
$lastName = $input['last_name'] ?? null;
$accountName = $input['account_name'] ?? null;

$lead->save();
$input['lead_id'] = $lead->id;

echo json_encode($input);




$entry_point_registry['LeadThankYou'] = array(
    'file' => 'custom/LeadThankYou.php',
    'auth' => false,
);

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once 'include/entryPoint.php';

$id = $_GET['id'] ?? '';

echo "<h1>🎉 Thank You!</h1>";
echo "<p>Your lead has been created successfully.</p>";
if ($id) {
    echo "<p><a href='index.php?module=Leads&action=DetailView&record={$id}'>View Lead</a></p>";
}


  $entry_point_registry['MyTimeEntryPoint'] = array(
      'file' => 'custom/MyTimeEntryPoint.php',
      'auth' => true,
  );

  if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
$date = new DateTime();
// echo $date->format('r');
?>