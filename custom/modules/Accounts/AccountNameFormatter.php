<?php

class AccountNameFormatter
{
    /**
     * Format the Account Name before saving.
     *
     * @param $bean  The Account bean
     * @param $event The event that triggered the hook (before_save)
     * @param $arguments Additional arguments passed by the hook
     */
    public function formatAccountName($bean, $event, $arguments)
    {
        // Check if the fields exist and are not empty
        if (!empty($bean->name) && !empty($bean->account_type) && !empty($bean->industry)) {
            // Concatenate name, account_type, and industry
            $bean->name = $bean->name . ' - ' . $bean->account_type . ' - ' . $bean->industry;
        } else {
            // If any of the fields are empty, handle it (you may choose to leave the name as is, or log an error)
            $bean->name = $bean->name . ' - [Missing Type or Industry]';
        }
    }
}
