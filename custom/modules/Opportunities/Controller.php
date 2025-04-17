<?php
require_once 'include/MVC/Controller/SugarController.php';
class OpportunitiesController extends SugarController
{
    public function action_CustomOpportunities()
    {
        $this->view = 'CustomOpportunities';
    }
    // public function action_OtherThanCustomerPartnersAccounts()
    // {
    //     $this->view = 'otherthancustomerpartnersaccounts';
    // }

    public function action_LostOpportunities()
    {
        $this->view = 'LostOpportunities';
    }

}