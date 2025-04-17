<?php

class AccountLogger
{
    public function logAccountName($bean, $event, $arguments)
    {
        $accountName = $bean->name;
        $GLOBALS['log']->fatal("Account saved: " . $accountName);
    }
}
