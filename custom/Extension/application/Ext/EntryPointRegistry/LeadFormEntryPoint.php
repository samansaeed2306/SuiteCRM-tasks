<?php
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
// Redirect to Thank You page
// header("Location: index.php?entryPoint=LeadThankYou&id={$lead->id}");
// exit;

