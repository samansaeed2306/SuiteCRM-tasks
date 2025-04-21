<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Safer email sender for SuiteCRM logic hooks
require_once 'include/SugarPHPMailer.php';

class LeadEmailHook
{
    public function sendEmailToAssignedUser($bean, $event, $arguments)
    {
        // Only run on create, not update
        if (empty($bean->fetched_row)) {
            $GLOBALS['log']->fatal('Lead hook triggered');

            try {
                // Get assigned user
                $assignedUser = BeanFactory::getBean('Users', $bean->assigned_user_id);

                if (!$assignedUser || empty($assignedUser->email1)) {
                    $GLOBALS['log']->fatal('Assigned user not found or has no email.');
                    return;
                }

                // Prepare and send email
                $mail = new SugarPHPMailer();
                $mail->setMailerForSystem();

                $mail->From = 'saman@sage-teck.com';
                $mail->FromName = 'SuiteCRM';
                $mail->Subject = "New Lead Assigned: {$bean->name}";
                $mail->Body = "A new lead has been assigned to you.\n\nLead Name: {$bean->name}";
                $mail->prepForOutbound();

                $mail->AddAddress($assignedUser->email1);

                if (!$mail->Send()) {
                    $GLOBALS['log']->fatal("Email send failed: " . $mail->ErrorInfo);
                } else {
                    $GLOBALS['log']->fatal("Email sent successfully to " . $assignedUser->email1);
                }

            } catch (Exception $e) {
                $GLOBALS['log']->fatal("Exception in email hook: " . $e->getMessage());
            }
        }
    }
}
