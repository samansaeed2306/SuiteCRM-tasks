<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
error_reporting(E_ERROR | E_PARSE);
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

require_once 'include/entryPoint.php';
require_once 'modules/Leads/Lead.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['last_name']) || !isset($input['account_name'])) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing required fields: last_name and account_name.'
    ]);
    exit;
}

try {
    $lead = new Lead();
    $lead->last_name = $input['last_name'];
    $lead->account_name = $input['account_name'];
    $lead->first_name = $input['first_name'] ?? '';
    $lead->email1 = $input['email'] ?? '';
    $lead->description = $input['description'] ?? '';
    $lead->status = 'New';
    $lead->assigned_user_id = 1;
    $lead->save();

    echo json_encode([
        'status' => 'success',
        'lead_id' => $lead->id,
        'message' => 'Lead created successfully.'
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Error saving lead: ' . $e->getMessage()
    ]);
}
