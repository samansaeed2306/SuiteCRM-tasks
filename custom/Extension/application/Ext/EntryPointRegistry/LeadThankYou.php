<?php
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
