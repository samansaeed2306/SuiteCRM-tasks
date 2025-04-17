<?php
require_once 'include/MVC/View/views/view.list.php';

class OpportunitiesViewLostOpportunities extends ViewList
{
    public function preDisplay()
    {
        parent::preDisplay();
    }

public function listViewProcess()
{
    $this->params['custom_where'] = " AND opportunities.sales_stage = 'Closed Lost'";
    parent::listViewProcess();
}

public function display()
{
    echo "<h2 style='padding: 10px; color: #d66c60;'>Other Than Customer and Partner Accounts</h2>";
    parent::display();
}
}